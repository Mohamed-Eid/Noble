<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('dashboard.profiles.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'image' => 'image',
        ]);
        $data = $request->except(['image']);

        if ($request->image) {

            if ($user->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
            }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/user_images/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }

        $user->update($data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.profiles.edit');
    }

    public function change_password()
    {
        $user = auth()->user();
        return view('dashboard.profiles.change_password', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function change_password_method(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'old_password' => 'required',
            'password'     => 'required|confirmed',
        ]);
       // dd(Hash::check($request->old_password, $user->password));
        if(Hash::check($request->old_password, $user->password))
        {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
            
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.index');
        }
        else 
        {
            return back()->withErrors(__('site.worng_old_password'));

        }
    }

}
