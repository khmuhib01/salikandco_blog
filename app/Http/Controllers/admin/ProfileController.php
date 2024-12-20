<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Image;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.show');
    }

    public function show()
    {
        return view('admin.profile.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::find($id);
        return view('admin.profile.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'mobile_no' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif,svg|max:2048',
            'image.*' => 'mimes:jpeg,jpg,png,gif,svg|max:2048'
        ]);

        try {
            $fileName = '';
            $data = User::find($id);
            if ($request->hasFile('image')) :

                if (!empty($data) && $data->image != "") {
                    if (File::exists('storage/image/avatars/' . $data->image)) {
                        File::delete('storage/image/avatars/' . $data->image);
                    }

                    if (File::exists('storage/image/avatars/thumbnail/' . $data->image)) {
                        File::delete('storage/image/avatars/thumbnail/' . $data->image);
                    }
                }

                $image = $request->file('image');
                $fileName = 'profile_' . Auth::user()->id . time() . '.' . $image->extension();;
                $img = image::make($image->getRealPath());
                $img->resize(180, 200, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->stream(); // <-- Key point
                $dir = public_path('storage/app/public/image/avatars/');

                if (!file_exists($dir) && !is_dir($dir)) :
                    mkdir($dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/avatars/' . $fileName, $img);

                $thum_img = image::make($image->getRealPath());
                $thum_img->resize(36, 36, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $thum_img->stream(); // <-- Key point
                $thum_dir = public_path('storage/app/public/image/avatars/thumbnail/');

                if (!file_exists($thum_dir) && !is_dir($thum_dir)) :
                    mkdir($thum_dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/avatars/thumbnail/' . $fileName, $thum_img);

            endif;

            $update = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_no' => $request->mobile_no,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            if ($fileName != "") :
                $update['image'] = $fileName;
            endif;

            $result = $data->update($update);
            if ($result > 0) :
                $request->session()->flash('message', 'User details was successfully updated!');
            else :
                $request->session()->flash('message', 'User details update failed!');
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
        }
        return redirect()->back();
    }

    public function change_password()
    {
        $action_url = 'admin/update-password/' . Auth::user()->id . '/update';
        return view('admin.profile.change_password', compact('action_url'));
    }

    public function update_password(Request $request, $id)
    {
        $this->validate($request, [
            'current_Password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required_with:new_password|same:new_password|min:8'
        ]);

        $user = User::findOrFail($id);
        if (!Hash::check($request->confirm_password, $user->password)) :
            $update = $user->fill([
                'password' => Hash::make($request->confirm_password)
            ])->save();

            if ($update > 0) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Password has been updated', 'current_pass' => '', 'new_pass' => '', 'confirm_pass' => '']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Password update failed', 'current_pass' => $request->current_Password, 'new_pass' => $request->new_password, 'confirm_pass' => $request->confirm_password]);
            endif;
        else :
            $request->session()->flash('message', ['status' => 0,  'text' => 'Current Password does not match', 'current_pass' => $request->current_Password, 'new_pass' => $request->new_password, 'confirm_pass' => $request->confirm_password]);
        endif;
        return redirect()->back();
    }
}
