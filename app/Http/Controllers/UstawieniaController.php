<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;


class UstawieniaController extends Controller
{

  public function __construct(){
      $this->middleware(['auth','verified']);
  }

// Return view for Ustawienia page.
  public function index(){
    $user = User::find(auth()->user()->id);
    return view('pages/ustawienia')->with('user', $user);
  }

// change user password
  public function security(Request $request){

// Validate input data
  $this->validate($request, [
      'currentpassword' => 'required|password',
      'newpassword'     => 'required|min:6|same:confirmpassword',
      'confirmpassword' => 'required|min:6|same:newpassword',
  ]);

    $user = User::find(auth()->user()->id);

    $currentpassword = $request->input('currentpassword');

// compare validated input password with current hashed value from model.
// If password match overwrite it with new hashed value.
    if (Hash::check("$currentpassword", "$user->password")) {
      $user->password = Hash::make($request->input('newpassword'));
      $user->save();
      $message = 'Twoje hasło zostało poprawnie zmienione';
    }else{
      $message = 'Obecne hasło jest nieprawidłowe';
    }
// Route back to settings tab.
    return redirect()->route('ustawienia')->with('message', $message);
  }


// Change user contact data.
  public function contact(Request $request){
// Validate inputs.
    $this->validate($request, [
      'email' => 'nullable|email|unique:users,email',
      'phonenumber' => 'nullable|numeric|digits:9'
    ]);

    $user = User::find(auth()->user()->id);

    $phonenumber = $request->input('phonenumber');
    $email = $request->input('email');


// Check for empty inputs and overwrite user data.
    if (!empty($email) && $email !== $user->email){
      $user->email = $email;
      $user->save();

      $message = 'Twoje dane zostały poprawnie zmienione';
    }

// Check for empty inputs and overwrite user data.
    if(!empty($phonenumber) && $phonenumber !== $user->phonenumber){
      $user->phonenumber = $phonenumber;
      $user->save();
      $message = 'Twoje dane zostały poprawnie zmienione';
    }

// Route back to settings tab.
    if(isset($message)){
      return redirect()->route('ustawienia')->with('message', $message);
    }else{
      return redirect()->route('ustawienia');
    }
  }


// Set notifications status(on/off switch) for receiving new messages from users.
  public function changeNotification(Request $request){
    $user = User::find(auth()->user()->id);
// Check for current notifications status from Model.
// Change norification status depending of their current value.
    if($user->notifications == true){
      $user->notifications = false;
      $message = 'Powiadomienia zostały wyłączone.';
    }elseif($user->notifications == false){
      $user->notifications = true;
      $message = 'Powiadomienia zostały włączone.';
    }
// Save data in DB and redirect back to settings.
    $user->save();
    return redirect()->back()->with('message', $message);
  }


// Deactivate User account by changing modal value for user->deleted.
// Saving Data in DB and logs out the user.
  public function deactivate(Request $request){
    $user = User::find(auth()->user()->id);
    $user->deleted = true;
    $user->save();
    Auth::logout();
    return redirect('/login');
  }
}
