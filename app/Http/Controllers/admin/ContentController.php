<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Categorie;
use App\Models\admin\PostContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Image;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $categories_lists = Categorie::where('status', '1')->orderBy('id')->get();
        return view('admin.content.index', compact('categories_lists'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required',
            'slug' => 'required|unique:post_contents,slug',
            'content' => 'required',
            'image.*' => 'mimes:jpeg,jpg,png|max:2048',
            'status' => 'required',
        ]);

        try {

            $fileName = '';
            if ($request->hasFile('image')) :
                $image = $request->file('image');
                $fileName   = 'post_image_' . Auth::user()->id . time() . '.' . $image->extension();;
                $img = image::make($image->getRealPath());
                $img->resize(1280, 640, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->stream(); // <-- Key point
                $dir = public_path('storage/app/public/image/post_image/');

                if (!file_exists($dir) && !is_dir($dir)) :
                    mkdir($dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/post_image/' . $fileName, $img);

                $thum_img = image::make($image->getRealPath());
                $thum_img->resize(568, 530, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $thum_img->stream(); // <-- Key point
                $thum_dir = public_path('storage/app/public/image/post_image/thumbnail/');

                if (!file_exists($thum_dir) && !is_dir($thum_dir)) :
                    mkdir($thum_dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/post_image/thumbnail/' . $fileName, $thum_img);

                $thum_small_img = image::make($image->getRealPath());
                $thum_small_img->resize(120, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $thum_small_img->stream(); // <-- Key point
                $thum_small_dir = public_path('storage/app/public/image/post_image/thumbnail/small/');

                if (!file_exists($thum_small_dir) && !is_dir($thum_small_dir)) :
                    mkdir($thum_small_dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/post_image/thumbnail/small/' . $fileName, $thum_small_img);

                $thum_big_img = image::make($image->getRealPath());
                $thum_big_img->resize(568, 406, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $thum_big_img->stream(); // <-- Key point
                $thum_big_dir = public_path('storage/app/public/image/post_image/thumbnail/big/');

                if (!file_exists($thum_big_dir) && !is_dir($thum_big_dir)) :
                    mkdir($thum_big_dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/post_image/thumbnail/big/' . $fileName, $thum_big_img);

            endif;

            $insert = PostContent::create([
                'categories_id' => $request->category_id,
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->content,
                'mata_title' => $request->mata_title,
                'mata_description' => $request->mata_description,
                'image' => $fileName != "" ? $fileName : '',
                'status' => $request->status,
                'created_by' => Auth::user()->id,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Content Add successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Content Add failed.']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0,  'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }

    public function show(Request $request)
    {
        $sql = PostContent::orderBy('id', 'desc')->with('get_categories');

        if (!empty($request->q)) {
            $sql->Where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('slug', 'LIKE', '%' . $request->q . '%')
                ->orWhere('description', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 20;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.content.show', compact('lists', 'serial', 'records'));
    }

    public function edit(Request $request, $id)
    {
        $nav_lists = Categorie::where('status', '1')->orderBy('id')->get();
        $getContent = PostContent::find($id);
        return view('admin.content.edit', compact('nav_lists', 'getContent'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required',
            'slug' => 'required|unique:post_contents,slug,'.$request->id,
            'content' => 'required',
            'image.*' => 'mimes:jpeg,jpg,png|max:2048',
            'status' => 'required',
        ]);

        try {
            $fileName = '';
            if ($request->hasFile('image')) :
                if (!empty($data) && $data->image != "") :
                    if (File::exists('storage/image/post_image/' . $data->image)) :
                        File::delete('storage/image/post_image/' . $data->image);
                    endif;

                    if (File::exists('storage/image/post_image/thumbnail/' . $data->image)) :
                        File::delete('storage/image/post_image/thumbnail/' . $data->image);
                    endif;

                    if (File::exists('storage/image/post_image/thumbnail/small/' . $data->image)) :
                        File::delete('storage/image/post_image/thumbnail/small/' . $data->image);
                    endif;

                    if (File::exists('storage/image/post_image/thumbnail/big/' . $data->image)) :
                        File::delete('storage/image/post_image/thumbnail/big/' . $data->image);
                    endif;
                endif;

                $image = $request->file('image');
                $fileName   = 'post_image_' . Auth::user()->id . time() . '.' . $image->extension();;
                $img = image::make($image->getRealPath());
                $img->resize(1280, 640, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->stream(); // <-- Key point
                $dir = public_path('storage/app/public/image/post_image/');

                if (!file_exists($dir) && !is_dir($dir)) :
                    mkdir($dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/post_image/' . $fileName, $img);

                $thum_img = image::make($image->getRealPath());
                $thum_img->resize(568, 530, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $thum_img->stream(); // <-- Key point
                $thum_dir = public_path('storage/app/public/image/post_image/thumbnail/');

                if (!file_exists($thum_dir) && !is_dir($thum_dir)) :
                    mkdir($thum_dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/post_image/thumbnail/' . $fileName, $thum_img);

                $thum_small_img = image::make($image->getRealPath());
                $thum_small_img->resize(120, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $thum_small_img->stream(); // <-- Key point
                $thum_small_dir = public_path('storage/app/public/image/post_image/thumbnail/small/');

                if (!file_exists($thum_small_dir) && !is_dir($thum_small_dir)) :
                    mkdir($thum_small_dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/post_image/thumbnail/small/' . $fileName, $thum_small_img);

                $thum_big_img = image::make($image->getRealPath());
                $thum_big_img->resize(568, 406, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $thum_big_img->stream(); // <-- Key point
                $thum_big_dir = public_path('storage/app/public/image/post_image/thumbnail/big/');

                if (!file_exists($thum_big_dir) && !is_dir($thum_big_dir)) :
                    mkdir($thum_big_dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/post_image/thumbnail/big/' . $fileName, $thum_big_img);

            endif;

            $updateData = [
                'categories_id' => $request->category_id,
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->content,
                'mata_title' => $request->mata_title,
                'mata_description' => $request->mata_description,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            if ($fileName !="") :
                $updateData['image'] = $fileName;
            endif;

            $data = PostContent::find($request->id);
            $update = $data->update($updateData);

            if ($update) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Content update successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Content update failed.']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0,  'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :
            $data = PostContent::find($request->id);
            if ($data !="") :
                $image = $data->image;
                $result = $data->delete();
                if ($result) :
                    if ($image != "") :
                        if (File::exists('storage/image/post_image/' . $image)) :
                            File::delete('storage/image/post_image/' . $image);
                        endif;
    
                        if (File::exists('storage/image/post_image/thumbnail/' . $image)) :
                            File::delete('storage/image/post_image/thumbnail/' . $image);
                        endif;
    
                        if (File::exists('storage/image/post_image/thumbnail/small/' . $image)) :
                            File::delete('storage/image/post_image/thumbnail/small/' . $image);
                        endif;
    
                        if (File::exists('storage/image/post_image/thumbnail/big/' . $image)) :
                            File::delete('storage/image/post_image/thumbnail/big/' . $image);
                        endif;
                    endif;

                    return response()->json(['status' => 1, 'text' => 'Post content delete successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'Post content delete failed.']);
                endif;
            else :
                return response()->json(['status' => 0, 'text' => 'Post content file not found!']);
            endif;
        endif;
    }
}
