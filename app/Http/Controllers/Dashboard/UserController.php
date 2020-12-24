<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{


    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('destroy');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd(auth()->user()->id);
        $users = User::where('id','!=',auth()->user()->id)
                ->whereHas(
                    "roles" , function($q){
                        return $q->where("name",'!=','super_admin');
                    }
                )->latest()->paginate(10);

        //d($users);
        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name','!=','super_admin')->get();
        return view('dashboard.users.create',compact('roles'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            // 'permissions' => 'required|min:1',
            'role'        => 'required',
        ]);
        $data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $data['password'] = bcrypt($request->password);

        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/user_images/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }

        $user = User::create($data);

        $user->attachRole($request->role);

        $role = Role::find($request->role);

        $user->syncPermissions($role->permissions);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::where('name','!=','super_admin')->get();
        return view('dashboard.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'image' => 'image',
            //'permissions' => 'required|min:1',

        ]);
        $data = $request->except(['permissions', 'image']);

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
        
        $user->detachRoles($user->roles); // parameter can be a Role object, array, id or the role string name

        $user->attachRole($request->role);

        $role = Role::find($request->role);

        $user->syncPermissions($role->permissions);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
        }

        $user->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.users.index');
    }
}
