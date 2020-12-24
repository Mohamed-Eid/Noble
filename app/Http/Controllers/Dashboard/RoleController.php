<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;

class RoleController extends Controller
{
    // ['ability:super-admin,read_roles']
    
        public function __construct()
    {
        $this->middleware(['ability:super_admin,read_roles'])->only('index');
        $this->middleware(['ability:super_admin,create_roles'])->only('create');
        $this->middleware(['ability:super_admin,update_roles'])->only('edit');
        $this->middleware(['ability:super_admin,delete_roles'])->only('destroy');

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('super_admin')){
            $roles = Role::paginate(10);
        }else{
            $roles = Role::where('name','!=','super_admin')->paginate(10);
        }
        return view('dashboard.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('dashboard.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions',
            'display_name' => 'required',
            'permissions' => 'required|array|min:1'
        ]);

        $role = Role::create($request->except('permissions'));
        
        $role->permissions()->sync($request->permissions);
        

        return redirect()->route('dashboard.roles.index')->with('success','تم اضافه الدور بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('dashboard.roles.edit',compact('permissions','role'));
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:permissions',
            'display_name' => 'required',
            'permissions' => 'required|array|min:1'

        ]);

        $role->update($request->except('permissions'));
        
        $role->syncPermissions($request->permissions);
        

        return redirect()->back()->with('success','تم تعديل الدور بنجاح');    
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if($role->name == 'super_admin'){
            return redirect()->back()->with('success','لا يمكن حذف هذا الدور');    
        }
        
        $role->delete();
        
        return redirect()->back()->with('success','تم حذف الدور بنجاح');    
    }
}
