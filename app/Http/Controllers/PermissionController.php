<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Session;

class PermissionController extends Controller {

    public function __construct() {
        $this->middleware(['auth', 'isAdmin']); 
    }

    public function index() {
		
		if( ! Auth::user()->hasPermissionTo('Administer roles & permissions')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
		
		$search = \Request::get('search');
		
		$permissions = Permission::where('name','like','%'.$search.'%')	
				->orderBy('name')->paginate(config('cockpit.listitems'));
				
		return view('permissions.index',compact('permissions'))
					->with('i', (request()->input('page', 1) - 1) * config('cockpit.listitems'));
						
    }

    public function create() {
        
        if( ! Auth::user()->hasPermissionTo('Permission - add')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
        
        $roles = Role::get();

		return view('permissions.create')->with('roles', $roles);	
    }

    public function store(Request $request) {
        
        $this->validate($request, [
            'name'=>'required|min:5|max:255',
        ]);

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();

        if (!empty($request['roles'])) { // If one or more role is selected
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); // Match input role to db record

                $permission = Permission::where('name', '=', $name)->first(); // Match input //permission to db record
                
                $r->givePermissionTo($permission);
            }
        }

        return redirect()->route('permissions.index')
            	->with('message', array('type' => 'success', 'text' => __('Permission <strong>:name</strong> successfully added', ['name' => $permission->name])));     

    }

    public function show($id) {
        
        return redirect()->route('home')
        ->with('message', array('type' => 'danger', 'text' => __('View a single permission is not permitted')));
    }

    public function edit($id) {
    	
    	if( ! Auth::user()->hasPermissionTo('Permission - edit')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
    	
    	$permission = Permission::findOrFail($id);
	    
	    $roles = Role::all();
	
		return view('permissions.edit', compact('permission', 'roles'));   
    }

    public function update(Request $request, $id) {
        
        $permission = Permission::findOrFail($id);
        
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);
        
        $input = $request->only('name');
        
        $permission->fill($input)->save();
        
        $roles = $request['roles'];
        
        if (isset($roles)) {        
            $permission->roles()->sync($roles);  //If one or more role is selected associate user to roles          
        }        
        else {
            $permission->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }

        return redirect()->route('permissions.index')
            ->with('message', array('type' => 'success', 'text' => __('Permission <strong>:name</strong> successfully edited', ['name' => $permission->name])));
    }
    
    public function destroy($id) {
        
        if( ! Auth::user()->hasPermissionTo('Permission - delete')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
        
        $permission = Permission::findOrFail($id);
	
		//Make it impossible to delete this specific permission 
		if ($permission->name == "Administer roles & permissions") {
	            return redirect()->route('permissions.index')
	            ->with('message', array('type' => 'danger', 'text' => __('Permission <strong>:name</strong> can be deleted', ['name' => $permission->name])));
	    }
	
		$permission->delete();
	
	    return redirect()->route('permissions.index')
	            ->with('message', array('type' => 'success', 'text' => __('Permission <strong>:name</strong> successfully deleted', ['name' => $permission->name]))); 	          

    }
    
}