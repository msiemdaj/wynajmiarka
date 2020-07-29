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

  public function index(){
    $user = User::find(auth()->user()->id);
    return view('pages/ustawienia')->with('user', $user);
  }

  public function security(Request $request){

$this->validate($request, [
    'currentpassword' => 'required|password',
    'newpassword'     => 'required|min:6|same:confirmpassword',
    'confirmpassword' => 'required|min:6|same:newpassword',
]);

    $user = User::find(auth()->user()->id);

    $currentpassword = $request->input('currentpassword');

    if (Hash::check("$currentpassword", "$user->password")) {
      $user->password = Hash::make($request->input('newpassword'));
      $user->save();
      $message = 'Twoje hasło zostało poprawnie zmienione';
    }else{
      $message = 'Obecne hasło jest nieprawidłowe';
    }
    return redirect()->route('ustawienia')->with('message', $message);
  }

  public function contact(Request $request){

    $this->validate($request, [
      'email' => 'nullable|email|unique:users,email', // CHECK FOR DUPLICATE
      'phonenumber' => 'nullable|numeric|digits:9'
    ]);

    $user = User::find(auth()->user()->id);

    $phonenumber = $request->input('phonenumber');
    $email = $request->input('email');

    if (!empty($email) && $email !== $user->email){
      $user->email = $email;
      $user->save();
      // $user->sendEmailVerificationNotification(); // jak wyslac to na nowy email bez jego wczesniejszej zmiany
      //                                             // zmienic email w bazie po jego veryfikazji z linku

      $message = 'Twoje dane zostały poprawnie zmienione';
    }

    if(!empty($phonenumber) && $phonenumber !== $user->phonenumber){
      $user->phonenumber = $phonenumber;
      $user->save();
      $message = 'Twoje dane zostały poprawnie zmienione';
    }

    if(isset($message)){
      return redirect()->route('ustawienia')->with('message', $message);

    }else{
      return redirect()->route('ustawienia');
    }
  }

  public function changeNotification(Request $request){
    $user = User::find(auth()->user()->id);
    if($user->notifications == true){
      $user->notifications = false;
      $message = 'Powiadomienia zostały wyłączone.';
    }elseif($user->notifications == false){
      $user->notifications = true;
      $message = 'Powiadomienia zostały włączone.';
    }
    $user->save();
    return redirect()->back()->with('message', $message);
  }

  public function deactivate(Request $request){
    $user = User::find(auth()->user()->id);
    $user->deleted = true;
    $user->save();
    Auth::logout();
    return redirect('/login');
  }
}
