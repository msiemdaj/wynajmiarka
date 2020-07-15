<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Ogloszenie;
use App\User;
use Mail;



class MessagesController extends Controller
{
  public function __construct()
  {
      $this->middleware(['auth','verified']);
  }

  public function index(){
    // podlad wszystkich wiadomosci
    $user_id = auth()->user()->id;
    $user = User::find($user_id);

    foreach($user->messages_received as $msgReceived){
      $sender = User::find($msgReceived->sender_id);
      $msgReceived->name = $sender->name;
    }

    foreach($user->messages_sent as $msgSent){
      $receiver = User::find($msgSent->receiver_id);
      $msgSent->name = $receiver->name;
    }

    return view('pages/wiadomosci/skrzynka')->with(['messages_sent' => $user->messages_sent->where('deleted_by_sender', false)->sortByDesc('sent_at'),
                                                    'messages_received' => $user->messages_received->where('deleted_by_receiver', false)->sortByDesc('sent_at')]);

  }

  public function sendMessage(Request $request, $id){
    $ogloszenie = Ogloszenie::find($id);
    $msgTitle = $request->input('title');
    $msgText = $request->input('message_body');

    if(empty($msgTitle) || empty($msgText)){
      $errormessage = 'Wypełnij wszystkie pola.';
      return back()->with('errormessage', $errormessage);
    }

    $user = User::find($ogloszenie->user_id);

    $wiadomosc = new Message;
    $wiadomosc->title = $msgTitle;
    $wiadomosc->message_body = $msgText;
    $wiadomosc->sender_id = auth()->user()->id;
    $wiadomosc->receiver_id = $ogloszenie->user_id;
    $saved = $wiadomosc->save();

    if ($saved) {
      $message = 'Wiadomość została wysłana.';
    }else{
      $message = 'Nie udało się wysłać twojej wiadomości.';
    }

    $toUser = User::find($ogloszenie->user_id);
    if($toUser->notifications == true){
      Mail::raw('Witaj, w twojej skrzynce na http://www.wynajmiarka.build znajduje się nowa wiadomość. Zaloguj się i odczytaj ją!',
      function ($message) use($toUser){
    $message->to($toUser->email)
      ->subject('Wynajmiarka - masz nową wiadomość!');
      });
    }
    return back()->with('message', $message);
  }

  public function show($id){

    $wiadomosc = Message::find($id);

    if($wiadomosc){
      if($wiadomosc->receiver_id == auth()->user()->id){
        $wiadomosc->viewed = 1;
        $wiadomosc->save();
      }

      $receiver = User::find($wiadomosc->receiver_id);
      $wiadomosc->receiver_name = $receiver->name;

      $sender = User::find($wiadomosc->sender_id);
      $wiadomosc->sender_name = $sender->name;

    return view('pages/wiadomosci/showmessage')->with('wiadomosc', $wiadomosc);
    }else{
      return redirect()->back();
    }
  }

  public function replyMessage(Request $request, $id){
    $wiadomosc = Message::find($id);

    $msgTitle = $request->input('title');
    $msgText = $request->input('message_body');

    if(empty($msgTitle) || empty($msgText)){
      $errormessage = 'Wypełnij wszystkie pola.';
      return back()->with('errormessage', $errormessage);
    }

    $newWiadomosc = new Message;
    $newWiadomosc->title = $msgTitle;
    $newWiadomosc->message_body = $msgText;
    $newWiadomosc->sender_id = auth()->user()->id;
    $newWiadomosc->receiver_id = $wiadomosc->sender_id;
    $saved = $newWiadomosc->save();

    if ($saved){
      $message = 'Wiadomość została wysłana.';
    }else{
      $message = 'Nie udało się wysłać twojej wiadomości.';
    }

    $toUser = User::find($wiadomosc->sender_id);
    if($toUser->notifications == true){
      Mail::raw('Witaj, w twojej skrzynce na http://www.wynajmiarka.build znajduje się nowa wiadomość. Zaloguj się i odczytaj ją!',
      function ($message) use($toUser){
    $message->to($toUser->email)
      ->subject('Wynajmiarka - masz nową wiadomość!');
      });
    }
    return back()->with('message', $message);
  }

  public function deleteMessage($id){
    $wiadomosc = Message::find($id);
    $user_id = auth()->user()->id;
    $user = User::find($user_id);

    if($wiadomosc->sender_id == $user_id){
      $wiadomosc->deleted_by_sender = 1;
      $wiadomosc->save();
    }elseif($wiadomosc->receiver_id == $user_id){
      $wiadomosc->deleted_by_receiver = 1;
      $wiadomosc->save();
    }

    $message = 'Wiadomość została usunięta.';
    return redirect()->route('skrzynka')->with('message', $message);
  }

  public function markAsNotViewed($id){
    $wiadomosc = Message::find($id);
    if($wiadomosc->viewed = true){
      $wiadomosc->viewed = false;
      $wiadomosc->save();
      $message = 'Wiadomość została oznaczona jako nieprzeczytana.';
      return redirect('/wiadomosci')->with('message', $message);
    }else{
      return redirect('/wiadomosci');
    }
  }

  public function changeViewedStatus($id){
    $wiadomosc = Message::find($id);
    if($wiadomosc->viewed == true){
      $wiadomosc->viewed = false;
      $wiadomosc->save();
    }elseif($wiadomosc->viewed == false){
      $wiadomosc->viewed = true;
      $wiadomosc->save();
    }
    return redirect('/wiadomosci');
  }

  public function deleteChecked(Request $request){
      $checked = $request->input('checkedMessage'); // array with ids
      if($checked){
      $user_id = auth()->user()->id;
      $user = User::find($user_id);

      foreach ($checked as $id){
        $wiadomosc = Message::find($id);

        if($wiadomosc->sender_id == $user_id){
          $wiadomosc->deleted_by_sender = 1;
          $wiadomosc->save();
        }elseif($wiadomosc->receiver_id == $user_id){
          $wiadomosc->deleted_by_receiver = 1;
          $wiadomosc->save();
        }
      }
    }
      return redirect()->route('skrzynka');
  }

  public function skrzynkaOptions(Request $request){
    $user_id = auth()->user()->id;
    $user = User::find($user_id);
    $checked = $request->input('checkedMessage');
    $tab = $request->input('tabn');
    if($checked){
      if($request->deletesubmit_x){
        foreach ($checked as $id){
          $wiadomosc = Message::find($id);
          if($wiadomosc->sender_id == $user_id){
            $wiadomosc->deleted_by_sender = 1;
            $wiadomosc->save();
          }elseif($wiadomosc->receiver_id == $user_id){
            $wiadomosc->deleted_by_receiver = 1;
            $wiadomosc->save();
          }
        }
      }elseif($request->setReaded_x){
        foreach ($checked as $id){
          $wiadomosc = Message::find($id);
          if($wiadomosc->deleted_by_receiver == false){
            $wiadomosc->viewed = true;
            $wiadomosc->save();
          }
        }
      }elseif($request->setUnreaded_x){
        foreach ($checked as $id){
          $wiadomosc = Message::find($id);
          if($wiadomosc->deleted_by_receiver == false){
            $wiadomosc->viewed = false;
            $wiadomosc->save();
          }
        }
      }
    }
    // return redirect()->route('skrzynka');
    return back()->withInput(['tab'=> $tab ]);
  }
}
