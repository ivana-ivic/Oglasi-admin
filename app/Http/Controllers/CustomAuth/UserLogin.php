<?php

namespace Oglasi\Http\Controllers\CustomAuth;

use Illuminate\Http\Request;
use Oglasi\Http\Controllers\Controller;
use Oglasi\User;
use Illuminate\Support\Facades\Hash;
use Session;

class UserLogin extends Controller
{
  public function __construct() {
    // $this->middleware('guest:admin');
  }

  // public function showLoginForm() {
	// 	return view('auth.login');
	// }

	public function login(Request $request) {

    $this->validate($request, [
    'username' => 'required',
    'password' => 'required',
    ]);

    if(session()->has('username')){
      return redirect()->route('home');
    }

    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $doc = $client->findDocument($request->username);

    $user_status=$doc->status;

    if($user_status=="404"){
      return redirect()->back()->withInput($request->only('username'));
    }

    if($request->password===$doc->body['password']){
      session()->put('username', $request->username);
      return redirect()->route('home');
    }

    return redirect()->back()->withInput($request->only('username'));
	}

  public function logout(){

    session()->flush();

    return redirect()->route('/');
  }
}
