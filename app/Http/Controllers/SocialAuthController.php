<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Redirect;
use Auth;
use App\User;

class SocialAuthController extends Controller
{
    public function redirect($service) {
        return Socialite::driver ( $service )->redirect ();
    }

   	public function callback($service) {
   		//return dd($service);
   		switch ($service) {
   			case 'facebook':
   				$user = Socialite::with ( $service )->user ();
        		$authUser = $this->FBLogin($user);
   				break;
   			
   			case 'google':
   				$user = Socialite::with ( $service )->user ();
        		$authUser = $this->GOLogin($user);
   				break;
   		}
   		       
        Auth::login($authUser, true);

        if (Auth::user()->password == null) {
        	//return view ( 'firstlogin' )->withDetails ( $user )->withService ( $service );
        	return redirect()->action('SocialAuthController@firstlogin');
        }
        
        return view ('view');
    }

    public function firstlogin()
    {
    	return view('firstlogin');
    }

    private function FBLogin($getUser)
    {	
    	//return dd($getUser,$getUser->avatar,$getUser->id);
        if ($authUser = User::where('email', $getUser->email)->first()) {
            return $authUser;
        }
 
        return User::create([
            'name' => $getUser->name,
            'email' => $getUser->email,
            'fb_id' => $getUser->id,
            'fb_avatar' => $getUser->avatar,
        ]);
    }

    private function GOLogin($getUser)
    {	
    	//return dd($getUser,$getUser->avatar,$getUser->id);
        if ($authUser = User::where('email', $getUser->email)->first()) {
            return $authUser;
        }
 
        return User::create([
            'name' => $getUser->name,
            'email' => $getUser->email,
            'g+_id' => $getUser->id,
            'g+_avatar' => $getUser->avatar
        ]);
    }

    public function firstsetpass(Request $request)
    {	
    	//return dd($request);

    	$validator = Validator::make($request->all(),[
				'password' => 'required|string|min:6|confirmed'
				]);

        if ($validator->fails()){
				return redirect('/firstlogin')
						->withErrors($validator)
						->withInput();
			}

        $user = user::find(Auth::id());
        $user -> password = bcrypt($request->password);
        $user -> save();

        return view ( 'view' );

    }
}
