<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Session;

class RoleController extends Controller {

    public function __construct() {
        
        $this->middleware(['auth', 'isAdmin']);
        
    }

    public function index() {
        
        if( ! Auth::user()->hasPermissionTo('Role - view')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
        
        $roles = Role::all(); 

        return view('roles.index')->with('roles', $roles);
    }

    public function create() {
        
        if( ! Auth::user()->hasPermissionTo('Role - add')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
        
        $permissions = Permission::orderBy('name', 'asc')->get();

        return view('roles.create', ['permissions'=>$permissions]);
    }

    public function store(Request $request) {
    
        $this->validate($request, [
            'name'=>'required|unique:roles|max:10',
            'permissions' =>'required',
            ]
        );

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();
		
		//Looping thru selected permissions
        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); 
			
			//Fetch the newly created role and assign permission
            $role = Role::where('name', '=', $name)->first(); 
            $role->givePermissionTo($p);
        }

        return redirect()->route('roles.index')
            	->with('message', array('type' => 'success', 'text' => __('Role <strong>:name</strong> successfully added', ['name' => $role->name])));       
    }
    
    public function show($id) {
        return redirect()->route('home')
        ->with('message', array('type' => 'danger', 'text' => __('View a single role is not permitted')));
    }

    public function edit($id) {
        
        if( ! Auth::user()->hasPermissionTo('Role - edit')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
        
        $role = Role::findOrFail($id);
        
        $permissions = Permission::all();

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id) {

        $role = Role::findOrFail($id);
    
        $this->validate($request, [
            'name'=>'required|max:10|unique:roles,name,'.$id,
            'permissions' =>'required',
        ]);

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        $p_all = Permission::all();//Get all permissions

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //Remove all permissions associated with role
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
            $role->givePermissionTo($p);  //Assign permission to role
        }

        return redirect()->route('roles.index')
            	->with('message', array('type' => 'success', 'text' => __('Role <strong>:name</strong> successfully edited', ['name' => $role->name])));
    }

    public function destroy($id)
    {
        if( ! Auth::user()->hasPermissionTo('Role - delete')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
        
        $role = Role::findOrFail($id);
        
        if($role->hasPermissionTo('Administer roles & permissions')) {
	            return redirect()->route('roles.index')
	            ->with('message', array('type' => 'danger', 'text' => __(' Role <strong>:name</strong> can be deleted', ['name' => $role->name])));
	    }
        
        $role->delete();
        
        return redirect()->route('roles.index')
            	->with('message', array('type' => 'success', 'text' => __('Role <strong>:name</strong> successfully deleted', ['name' => $role->name])));

    }
}