<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    	use AuthenticatesUsers;
    	
    	protected $redirectTo = '/employee';
    	protected $guard= 'web';
        

        public function check_login(Request $request)
        {
        	$this->validate($request,[
        		'username'=>'required',
        		'password'=>'required'
        	]);

        	$auth = Auth::guard('web')->attempt([
        		'username'=>$request->username,
        		'password'=>$request->password,
        		
    		]);
    		if($auth)
    		{
    			return redirect()->route('employee');
    		}else
    		{
    			return redirect()->back()
    			                 ->withErrors(array('message' => 'Username or password is invalid.'));
    		}
    		
    		
        }

        public function logout()
        {
        	Auth::guard('web')->logout();
        	return redirect('/');
        }
}
