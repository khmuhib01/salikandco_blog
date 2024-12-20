<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\admin\Categorie;
use App\Models\admin\PostContent;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request) 
    {
        $sql = PostContent::where('status', 'publish')->whereNotIn('categories_id',[4])->orderBy('id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('title', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('frontend/index', compact('lists', 'serial', 'records'));
    }

    public function getContentDetails(Request $request, $slug)
    {
        $getPostDetails = PostContent::where('slug', $slug)->where('status', 'publish')->first();
        if ($getPostDetails !="") :
			$view_count = ($getPostDetails->views + 1);
            $getPostDetails->update(['views' => $view_count]);
            return view('frontend/content_details',compact('getPostDetails'));
        else:
            return response(view('frontend/error'),404);
        endif;
    }

    public function getCategoriesList(Request $request, $category)
    {
        $getCategory = Categorie::where(['slug' => $category, 'status' => '1'])->first();
        $cat_id = 0;
        if (!empty($getCategory)) :
            $cat_id = $getCategory->id;
        endif;

        $sql = PostContent::where(['status' => 'publish', 'categories_id' => $cat_id])->orderBy('id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('title', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('frontend/index', compact('lists', 'serial', 'records'));
    }
}
