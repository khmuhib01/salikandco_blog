<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function show(Request $request)
    {
        $sql = Categorie::orderBy('categories.id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('categories.name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('categories.slug', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.setting.category', compact('lists', 'serial', 'records'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name',
            'slug' => 'required|unique:categories,slug',
        ]);
       
        try {
            $insert = Categorie::create([
                'name' => ucwords($request->name),
                'slug' => strtolower($request->slug),
                'created_by' => Auth::user()->id,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Menu add successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Menu add failed.']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0, 'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $data = Categorie::findOrFail($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$request->id,
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'errors' => $validator->errors()]);
        else :
            $updateData = [
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            $data = Categorie::find($request->id);
            $update = $data->update($updateData);

            if ($update) :
                return response()->json(['status' => 1, 'text' => 'Manu update successfully']);
            else :
                return response()->json(['status' => 0, 'text' => 'Manu update failed.']);
            endif;
        endif;
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :
            $data = Categorie::find($request->id);
            $delete = $data->delete();
            if ($delete) :
                $data->update(['status' => '0', 'updated_by' => Auth::user()->id]);
                return response()->json(['status' => 1, 'text' => 'Manu delete successfully']);
            else :
                return response()->json(['status' => 0, 'text' => 'Manu delete failed.']);
            endif;
        endif;
    }

    public function sort(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'sortVal' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :
            if ($request->sortVal == 0) :
                $checkNav = [];
            else :
                $checkNav = Categorie::where(['sort' => $request->sortVal])->get();
            endif;

            if (count($checkNav) == 0) :
                $data = Categorie::find($request->id);
                $update = $data->update(['sort' => $request->sortVal]);

                if ($update) :
                    return response()->json(['status' => 1, 'text' => 'Sort '.$request->sortVal.' update successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'Sort '.$request->sortVal.' update failed.']);
                endif;
            else:
                return response()->json(['status' => 0, 'text' => 'This sort '.$request->sortVal.' already exists.']);
            endif;
        endif;
    }
}
