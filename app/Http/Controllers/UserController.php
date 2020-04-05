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

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
    
        $search = \Request::get('search');
		
		$users = User::where('name','like','%'.$search.'%')
				->orWhere('email', 'like','%'.$search.'%')	
				->orderBy('name')->paginate(50);	
		
		
		return view('users.index',compact('users'))
					->with('i', (request()->input('page', 1) - 1) * 50);		
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
    	if(Auth::user()->hasPermissionTo('Add user'))
	    {
	        $signalers = User::role('Signaling')->where('active', 1)->orderBy('name')->pluck('name', 'id')->toArray();
			$signalers = array('0' => __('messages.no_signaler')) + $signalers;
	        
	        $roles = Role::get();
	        return view('users.create', ['roles'=>$roles, 'signalers' => $signalers]);
	    }
	    else
	    {
		    return redirect()->route('home')
		    ->with('flash_message', __('You can\'t access to this resource'));
	    }    
	        
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
    //Validate name, email and password fields
        $this->validate($request, [
            'name'=>'required|max:191',
            'email'=>'required|email|max:191|unique:users',
            'password'=>'required|min:6|confirmed',
            'address'=>'min:3|max:191',
            'ntp'=>'min:3|max:5',
            'city'=>'min:1|max:191',
            'region'=>'min:2|max:191',
            'vat'=>'required_without_all:address,ntp,city,region|max:16',
            'locale' => 'required',
            'iban' => 'sometimes',
            'bic' => 'sometimes',
            
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'active' => 1,
            'address' => $request['address'],
            'ntp' => $request['ntp'],
            'city' => $request['city'],
            'region' => $request['region'],
            'vat' => $request['vat'],
            'signaling_id' => $request['signaling_id'],
            'locale' => $request['locale'],
            'iban' => $request['iban'],
            'bic' => $request['bic'],
        ]);

        $roles = $request['roles']; //Retrieving the roles field
    //Checking if a role was selected
        if (isset($roles)) {

            foreach ($roles as $role) {
            $role_r = Role::where('id', '=', $role)->firstOrFail();            
            $user->assignRole($role_r); //Assigning role to user
            }
        }
        
        Log::info('[MC]['.Auth::user()->name.'] Creazione utente: '.$user->id);
                
		if(Auth::user()->hasRole('Admin')) 
        {
	     	return redirect()->route('users.index')
            	->with('flash_message', __('messages.add_user_successfull'));   
        }
		elseif(Auth::user()->hasRole('Signaling'))
        {
	        return redirect()->route('dashboard')
	        ->with('flash_message', __('messages.add_user_successfull_next_steps'));
        }
        
              
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id) {
        if(Auth::user()->hasPermissionTo('View user'))
	    {
		    $user = User::findOrFail($id); 
	        $roles = Role::get();
	        $wallets = $user->wallets()->get();
	        $packages = Packages::where('active', 1)->get();
	        
	        // related
	        $cofinancing = $user->cofinancing()->get();
	        $cofinancing_count = $cofinancing->count();
	        $contracts = $user->contracts()->get();
	        $contracts_count = $contracts->count();
	        
	        $mc_mining = Mailchimp::check(config('miningcentral.mc_mining_list'), $user->email);
	        $mc_mining_status = Mailchimp::status(config('miningcentral.mc_mining_list'), $user->email);
	        $mc_signalers = Mailchimp::check(config('miningcentral.mc_signalers_list'), $user->email);
	        $mc_signalers_status = Mailchimp::status(config('miningcentral.mc_signalers_list'), $user->email);
	        $mc_financing = Mailchimp::check(config('miningcentral.mc_financing_list'), $user->email);
	        $mc_financing_status = Mailchimp::status(config('miningcentral.mc_financing_list'), $user->email);
	        $mc_deeplearning = Mailchimp::check(config('miningcentral.mc_deeplearning_list'), $user->email);
	        $mc_deeplearning_status = Mailchimp::status(config('miningcentral.mc_deeplearning_list'), $user->email);
	        
	        Log::info('[MC]['.Auth::user()->name.'] Visualizza Utente: '.$id); 
	
	        return view('users.show', compact('user', 'roles', 'wallets', 'packages', 'mc_mining', 'mc_mining_status', 'mc_signalers', 'mc_signalers_status', 'mc_financing', 'mc_financing_status', 'mc_deeplearning', 'mc_deeplearning_status', 'cofinancing_count', 'contracts_count'));
	         
		}
		else
	    {
		    return redirect()->route('users.index')
		    ->with('flash_message', __('You can\'t access to this resource'));
	    }     
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id) {
        if(Auth::user()->hasPermissionTo('Edit user'))
	    {
	        $user = User::findOrFail($id); //Get user with specified id
	        $roles = Role::get(); //Get all roles
	        $wallets = $user->wallets()->get();
	        
	        $signalers = User::role('Signaling')->where('active', 1)->orderBy('name')->pluck('name', 'id')->toArray();
			$signalers = array('0' => __('messages.no_signaler')) + $signalers;
	
	        return view('users.edit', compact('user', 'roles', 'wallets', 'signalers')); //pass user and roles data to view
	    }
	    else
	    {
		    return redirect()->route('dashboard')
		    ->with('flash_message', __('You can\'t access to this resource'));
	    }    

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
	            'address'=>'min:3|max:191',
	            'ntp'=>'min:3|max:5',
	            'city'=>'min:1|max:191',
	            'region'=>'min:2|max:191',
	            'vat'=>'required_without_all:address,ntp,city,region|max:16',
	           	'locale' => 'required',
	           	'iban' => 'sometimes',
			   	'bic' => 'sometimes', 
	        ]);
	        $input = $request->only(['name', 'email', 'password', 'address', 'ntp', 'city', 'region', 'vat', 'signaling_id', 'locale', 'iban', 'bic']);
	    }
	    else {
		    $this->validate($request, [
	            'name'=>'required|max:120',
	            'email'=>'required|email|unique:users,email,'.$id,
	            'address'=>'min:3|max:191',
	            'ntp'=>'min:3|max:5',
	            'city'=>'min:1|max:191',
	            'region'=>'min:2|max:191',
	            'vat'=>'required_without_all:address,ntp,city,region|max:16',
	            'locale' => 'required',
	            'iban' => 'sometimes',
			   	'bic' => 'sometimes',
	        ]);
		    $input = $request->only(['name', 'email', 'address', 'ntp', 'city', 'region', 'vat', 'signaling_id', 'locale', 'iban', 'bic']);
	    }
		
        $user->fill($input)->save();

		$roles = $request['roles']; //Retreive all roles
        if (isset($roles)) {        
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles          
        }        
        
        Log::info('[MC]['.Auth::user()->name.'] Aggiornamento Utente: '.$id);
        
        if(Auth::user()->hasanyrole('Admin|Team'))
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
	    if(Auth::user()->hasPermissionTo('Delete user'))
	    {
	        $user = User::findOrFail($id);
	        $user->roles()->detach(); 
	        $user->delete();
	        
	        // to do: verificare se ci sono altre tabelle collegate
	
	        Log::info('[MC]['.Auth::user()->name.'] Cancellazione Utente: '.$id);
	        
	        return redirect()->route('users.index')
	            ->with('flash_message', __('messages.delete_user_successfull'));
        }
	    else
	    {
		    return redirect()->route('users.index')
		    ->with('flash_message', __('You can\'t access to this resource'));
	    }    
    }
    
    /**
    * Change state of the specified resource from storage.
    *
    * @param  int  $id, $state
    * @return \Illuminate\Http\Response
    */
    public function changeState($id, $state)
    {
	    if(!Auth::user()->hasPermissionTo('Change user state')) return redirect()->route('users.index')
		    ->with('flash_message', __('You can\'t access to this resource'));
	    
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
	
	        return view('users.profile', compact('user', 'wallets', 'roles', 'cofinancing_count', 'contracts_count')); 	        

    }
    
    /*
	 * Direct assign permession
	 */
	public function personalPermissions($id)
	{
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
    
    public function payments($id = null)
    {
	    if(Auth::user()->hasAnyRole('User', 'Signaling') || $id == null )
	    {
		    $id = Auth::user()->id; 
	    }
	    
	    $user = User::findOrFail($id);
	    $contracts = $user->contracts()->get();
	    
	    return view('users.payments', compact('id','user', 'contracts'));
    }
    
    public function cofinancepayments($id = null)
    {
	    if(Auth::user()->hasAnyRole('User', 'Signaling'))
	    {
		    $id = Auth::user()->id; 
	    }
	    
	    $user = User::findOrFail($id);
	    $contracts = $user->cofinancing()->get();
	    
	    return view('users.cofinancepayments', compact('id','user', 'contracts'));
    }
    
	    
    /**
    * Change state of Mailchimp subscription.
    *
    * @param  int  $id, $list, $state
    * @return \Illuminate\Http\Response
    */
    public function changeMCState($id, $list, $state)
    {
	    if(!Auth::user()->hasPermissionTo('Change user state')) return redirect()->route('users.index')
		    ->with('flash_message', __('You can\'t access to this resource'));
	    
	    $user = User::findOrFail($id);
	    
	    if($state == 'add')
	    {
		    $fullname = explode(" ", $user->name);
		    Mailchimp::subscribe($list, $user->email, $merge = ['FNAME' => $fullname[0], 'LNAME' => $fullname[1]], false);
	    }
	    if($state == 'remove')
	    {
		    Mailchimp::unsubscribe($list, $user->email);
	    }
	    
	    Log::info('[MC]['.Auth::user()->name.'] Cambio Stato/Utente: '.$state.'/'.$user->email);
	    
	    return redirect()->route('users.show', $id)
            ->with('flash_message', __('messages.edit_user_successfull'));
	    
    }
    
    public function walletlist()
    {
	    if(!Auth::user()->hasPermissionTo('Delete user')) return redirect()->route('users.index')
		    ->with('flash_message', __('You can\'t access to this resource'));
		    
		$users = User::where('name','like','%'.$search.'%')
				->orWhere('email', 'like','%'.$search.'%')	
				->orderBy('name')->paginate(50);    
    }
    
}