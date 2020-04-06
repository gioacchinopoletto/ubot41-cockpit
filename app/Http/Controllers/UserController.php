<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
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

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id) {
        
        if( ! Auth::user()->hasPermissionTo('User - view')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
        
        $user = User::findOrFail($id); 
	        
		$roles = Role::get();
	    
		return view('users.show', compact('user', 'roles'));    
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id) {
        
        if( ! Auth::user()->hasPermissionTo('User - edit')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
        
        $user = User::findOrFail($id); //Get user with specified id
        $roles = Role::get(); //Get all roles
        $wallets = $user->wallets()->get();
        
        $signalers = User::role('Signaling')->where('active', 1)->orderBy('name')->pluck('name', 'id')->toArray();
		$signalers = array('0' => __('messages.no_signaler')) + $signalers;

        return view('users.edit', compact('user', 'roles', 'wallets', 'signalers')); //pass user and roles data to view  
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id) {
        
        $user = User::findOrFail($id); //Get role specified by id

		$password = $request['password'];
        
        if (isset($password)) {
	        
	        $this->validate($request, [
	            'name'=>'required|max:120',
	            'email'=>'required|email|unique:users,email,'.$id,
	            'password'=>'required|min:6|confirmed', 
	        ]);
	        
	        $input = $request->only(['name', 'email', 'password']);
	    }
	    else {
		    
		    $this->validate($request, [
	            'name'=>'required|max:120',
	            'email'=>'required|email|unique:users,email,'.$id,
	        ]);
		    
		    $input = $request->only(['name', 'email']);
	    }
		
        $user->fill($input)->save();

		$roles = $request['roles']; //Retreive all roles
        
        if (isset($roles)) {        
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles          
        }        
        
        Log::info('[MC]['.Auth::user()->name.'] Aggiornamento Utente: '.$id);
        
        if(Auth::user()->hasanyrole('Admin'))
        {
        	return redirect()->route('users.index')
            	->with('flash_message', __('messages.edit_user_successfull'));
        }
        else
        {
	        return redirect()->route('users.profile')
            	->with('flash_message', __('messages.edit_user_successfull'));
        }    	
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id) {
	    
	    if( ! Auth::user()->hasPermissionTo('User - edit')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
	    
        $user = User::findOrFail($id);
        $user->roles()->detach(); 
        $user->delete();
        
        // to do: verificare se ci sono altre tabelle collegate

        Log::info('[MC]['.Auth::user()->name.'] Cancellazione Utente: '.$id);
        
        return redirect()->route('users.index')
            ->with('flash_message', __('messages.delete_user_successfull'));
            
    }
    
    /**
    * Change state of the specified resource from storage.
    *
    * @param  int  $id, $state
    * @return \Illuminate\Http\Response
    */
    public function changeState($id, $state)
    {
	    if( ! Auth::user()->hasPermissionTo('User - change state')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
	    
	    $user = User::findOrFail($id);
	    $user->active = $state;
	    $user->save();
	    
	    Log::info('[MC]['.Auth::user()->name.'] Cambio Stato/Utente: '.$state.'/'.$id);
	    
	    return redirect()->route('users.index')
            ->with('flash_message', __('messages.edit_user_successfull'));
	    
    }
    
    /**
    * Show the form for editing user profile.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function editProfile() {
        
    	$id = Auth::user()->id;
        $user = User::findOrFail($id); //Get user with specified id
        $wallets = $user->wallets()->get();
        $roles = $user->roles()->get();
        
        // related
        $cofinancing = $user->cofinancing()->get();
        $cofinancing_count = $cofinancing->count();
        $contracts = $user->contracts()->get();
        $contracts_count = $contracts->count();

        return view('users.profile', compact('user', 'roles')); 	        
    }
    
    /*
	 * Direct assign permession
	 */
	public function personalPermissions($id)
	{
		
		if( ! Auth::user()->hasPermissionTo('User - add single permission')) return redirect()->route('home')
		    ->with('message', array('type' => 'danger', 'text' => __("You can't access to this resource")));
		
		$user = User::findOrFail($id);
		
		$permissions = Permission::all();
		$permissions_from_role = $user->getPermissionsViaRoles();
		
		return view('users.permissions', compact('user', 'permissions', 'permissions_from_role'));
	} 
	 
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
	    
	    return redirect()->route('users.edit', $id)
		    ->with('flash_message', __('messages.edit_permissions_single_successfull'));
    }
    
    
	    
    
    
    
    
}