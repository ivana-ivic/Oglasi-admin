<?php

namespace Oglasi\Http\Controllers\CustomAuth;

use Illuminate\Http\Request;
use Oglasi\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Oglasi\User;
use Illuminate\Support\Facades\Hash;

class UserRegister extends Controller
{
  public function __construct() {
    // $this->middleware('guest:admin');
  }

  public function showRegisterForm() {
    return view('auth.register');
  }

  public function register(Request $request) {

    $this->validate($request, [
    'first_name' => 'required|max:50',
    'last_name' => 'required|max:50',
    'company_name' => 'required|max:100',
    'country' => 'required',
    'city' => 'required',
    'phone_number' => 'required|numeric|phone',
    'address' => 'required|max:100',
    'email' => 'email|max:100',
    'password' => 'required|min:8',
    ]);

    $user=new User([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'company_name' => $request->company_name,
      'country' => $request->country,
      'city' => $request->city,
      'phone_number' => $request->phone_number,
      'address' => $request->address,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => $request->user_role,
    ]);

    $user->save();

    return redirect()->route('login')->withInput($request->only('email'));

    // return redirect()->intended(route('admin.dashboard'));

    // protected $fillable = [
  	// 	'first_name', 'last_name', 'company_name', 'country', 'city', 'phone_number', 'address', 'email', 'password',
  	// ];
    // //validate the form data
    // $this->validate($request, [
    // 	'email' => 'required|email',
    // 	'password' => 'required|min:6',
    // ]);
    //
    // //attempt to log the user in
    // if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
    // 	//if successful, then redirect to their intended location
    // 	return redirect()->intended(route('admin.dashboard'));
    // }
    //
    // //if unsuccessful, then redirect back to the login with the form data
    // return redirect()->back()->withInput($request->only('email', 'remember'));
  }
}
