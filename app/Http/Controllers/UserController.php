<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use Auth;

use Illuminate\Support\Facades\Log;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


use Session;

class UserController extends Controller {

    public function __construct() {
        
        $this->middleware(['auth']); 
    
    }

    public function index() {
    
        if( ! Auth::user()->hasPermissionTo('User - view')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
        
        $search = \Request::get('search');
		
		$users = User::where('name','like','%'.$search.'%')
				->orWhere('email', 'like','%'.$search.'%')	
				->orderBy('name')->paginate(config('cockpit.listitems'));	
		
		
		return view('users.index',compact('users'))
					->with('i', (request()->input('page', 1) - 1) * config('cockpit.listitems'));		
    }

    public function create() {
    	
    	if( ! Auth::user()->hasPermissionTo('User - add')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
    	
	    $roles = Role::get();
	        
		return view('users.create', ['roles'=>$roles]);    
    }

    public function store(Request $request) {
   
        $this->validate($request, [
            'name'=>'required|max:191',
            'email'=>'required|email|max:191|unique:users',
            'password'=>'required|min:6|confirmed',
            'roles' =>'required',
            
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $roles = $request['roles']; //Retrieving the roles field
    
		//Checking if a role was selected
        if (isset($roles)) {

            foreach ($roles as $role) {
            $role_r = Role::where('id', '=', $role)->firstOrFail();            
            $user->assignRole($role_r); //Assigning role to user
            }
        }
        
        Log::info('['.Auth::user()->name.'] User - add: ('.$user->id.') '.$user->name);
                
		return redirect()->route('users.index')
            	->with('message', array('type' => 'success', 'text' => __("User <strong>:name</strong> successfully added", ['name' => $user->name]))); 
             
    }
    
    public function show($id) {
        
        if( ! Auth::user()->hasPermissionTo('User - view')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
        
        $user = User::findOrFail($id); 
	        
		$roles = Role::get();
		
		$hashUser = md5( strtolower(trim($user->email))); 
	    
		return view('users.show', compact('user', 'roles', 'hashUser'));    
    }

    public function edit($id) {
        
        if( ! Auth::user()->hasPermissionTo('User - edit')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
        
        $user = User::findOrFail($id); 
        $roles = Role::get();
        
        $hashUser = md5( strtolower(trim($user->email))); 

        return view('users.edit', compact('user', 'roles', 'hashUser')); 
    }

    public function update(Request $request, $id) {
        
        $user = User::findOrFail($id);

		$password = $request['password'];
        
        if (isset($password)) {
	        
	        $this->validate($request, [
	            'name'=>'required|max:120',
	            'email'=>'required|email|unique:users,email,'.$id,
	            'password'=>'required|min:6|confirmed' 
	        ]);
	        
	        $input = $request->only(['name', 'email', 'password']);
	        $input['password'] = Hash::make($input['password']);
	    }
	    else {
		    
		    $this->validate($request, [
	            'name'=>'required|max:120',
	            'email'=>'required|email|unique:users,email,'.$id
	        ]);
		    
		    $input = $request->only(['name', 'email']);
	    }
		
        $user->fill($input)->save();

		$roles = $request['roles']; //Retreive all roles
        
        if (isset($roles)) {        
            $user->roles()->sync($roles);        
        }        
        
        if(Auth::user()->hasanyrole('Admin'))
        {
        	return redirect()->route('users.index')
            	->with('message', array('type' => 'success', 'text' => __('User <strong>:name</strong> successfully edited', ['name' => $user->name])));
        }
        else
        {
	        return redirect()->route('users.profile')
            	->with('message', array('type' => 'success', 'text' => __('Profile successfully edited')));
        }    	
    }

    public function destroy($id) {
	    
	    if( ! Auth::user()->hasPermissionTo('User - delete')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
	    
        $user = User::findOrFail($id);
        $name_temp = $user->name;
        
        if(Auth::user()->id == $user->id) return redirect()->route('users.index')
	            ->with('message', array('type' => 'danger', 'text' => __("You can't delete yourself")));
        
        if($user->hasPermissionTo('Administer roles & permissions')) return redirect()->route('users.index')
	            ->with('message', array('type' => 'danger', 'text' => __("You can't delete an Admin, please change user role before delete it")));
        
        $user->roles()->detach(); 
        $user->delete();
        
        return redirect()->route('users.index')
	            ->with('message', array('type' => 'success', 'text' => __('User <strong>:name</strong> successfully deleted', ['name' => $name_temp])));
            
    }
    
    public function changeState($id, $state)
    {
	    if( ! Auth::user()->hasPermissionTo('User - change state')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
	    
	    $user = User::findOrFail($id);
	    $user->active = $state;
	    $user->save();	    
	   
	    return redirect()->route('users.index')
            ->with('message', array('type' => 'success', 'text' => __('User <strong>:name</strong> successfully edited', ['name' => $user->name])));
	    
    }
    
    public function editProfile() {
        
    	$id = Auth::user()->id;
        $user = User::findOrFail($id);
        
        $hashUser = md5( strtolower(trim($user->email)));
     
        return view('users.profile', compact('user', 'hashUser')); 	        
    }
    
	public function personalPermissions($id)
	{
		
		if( ! Auth::user()->hasPermissionTo('User - add single permission')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
		
		$user = User::findOrFail($id);
		
		$permissions = Permission::orderby('name', 'asc')->get();
		$permissions_from_role = $user->getPermissionsViaRoles();
		
		return view('users.permissions', compact('user', 'permissions', 'permissions_from_role'));
	} 
	
	/*
	 * sync permession
	 */ 
	public function syncPermissions(Request $request, $id)
    {
	    $user = User::findOrFail($id);
	    
	    $permissions = $request['permissions']; 
	    
	    if($permissions)
	    {
			$user->syncPermissions($permissions);    
	    }
	    else
	    {
		 	$user->syncPermissions();   
	    }
	    
	    return redirect()->route('users.index')
		     ->with('message', array('type' => 'success', 'text' => __('Personal permissions successfully edited for user <strong>:name</strong>', ['name' => $user->name])));
    }
    
    
	    
    
    
    
    
}