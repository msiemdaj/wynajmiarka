<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Ogloszenie;
use App\User;
use Mail;

class MessagesController extends Controller
{
  public function __construct(){
      $this->middleware(['auth','verified']);
  }

// Show view with All messages.
  public function index(){
    $user_id = auth()->user()->id;
    $user = User::find($user_id);

// Go through all messages received and bind sender name to it.
    foreach($user->messages_received as $msgReceived){
      $sender = User::find($msgReceived->sender_id);
      $msgReceived->name = $sender->name;
    }

// Go through all messages sent and bind receiver name to it.
    foreach($user->messages_sent as $msgSent){
      $receiver = User::find($msgSent->receiver_id);
      $msgSent->name = $receiver->name;
    }

// Return mailbox view with all messages not deleted by user.
    return view('pages/wiadomosci/skrzynka')->with(['messages_sent' => $user->messages_sent->where('deleted_by_sender', false)->sortByDesc('sent_at'),
                                                    'messages_received' => $user->messages_received->where('deleted_by_receiver', false)->sortByDesc('sent_at')]);
  }


// Send message to users.
  public function sendMessage(Request $request, $id){
// Find Ogloszenie Model related to message we want to send.
    $ogloszenie = Ogloszenie::find($id);
// Bind request inputs.
    $msgTitle = $request->input('title');
    $msgText = $request->input('message_body');

// Check if message content is not empty.
    if(empty($msgTitle) || empty($msgText)){
      $errormessage = 'Wypełnij wszystkie pola.';
      return back()->with('errormessage', $errormessage);
    }

// Find advertisement owner.
    $user = User::find($ogloszenie->user_id);

// Create new Message Model and Bind variables into it.
    $wiadomosc = new Message;
    $wiadomosc->title = $msgTitle;
    $wiadomosc->message_body = $msgText;
    $wiadomosc->sender_id = auth()->user()->id;
    $wiadomosc->receiver_id = $ogloszenie->user_id;

// Save data into DB.
    $saved = $wiadomosc->save();

    if ($saved) {
      $message = 'Wiadomość została wysłana.';
    }else{
      $message = 'Nie udało się wysłać twojej wiadomości.';
    }

// Check message receiver notifcation status.
// Send email to the user with notification about new message in mailbox if his notifications are turned on. Then redirect back.
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


// Preview certain received or sent message.
  public function show($id){
    $wiadomosc = Message::find($id);

// Mark message as viewed after triggering the function and showing the content.
    if($wiadomosc){
      if($wiadomosc->receiver_id == auth()->user()->id){
        $wiadomosc->viewed = 1;
        $wiadomosc->save();
      }

// Bind receiver name to message.
      $receiver = User::find($wiadomosc->receiver_id);
      $wiadomosc->receiver_name = $receiver->name;
// Bind sender name to message.
      $sender = User::find($wiadomosc->sender_id);
      $wiadomosc->sender_name = $sender->name;

// Validate logged user
    if(auth()->user() == $sender || auth()->user() == $receiver){
      if(auth()->user() == $sender && $wiadomosc->deleted_by_sender){
        return redirect()->back();
      }
      if(auth()->user() == $receiver && $wiadomosc->deleted_by_receiver){
        return redirect()->back();
      }
// Return showmessage view with data.
    return view('pages/wiadomosci/showmessage')->with('wiadomosc', $wiadomosc);
  }else{
    return redirect()->back();
  }
    }else{
      return redirect()->back();
    }
  }

// Reply to received message.
  public function replyMessage(Request $request, $id){
// Get Model
    $wiadomosc = Message::find($id);

// Get data from input request and bind it into variable.
    $msgTitle = $request->input('title');
    $msgText = $request->input('message_body');

// Check if data from request is empty.
    if(empty($msgTitle) || empty($msgText)){
      $errormessage = 'Wypełnij wszystkie pola.';
      return back()->with('errormessage', $errormessage);
    }

// Create new Model and bind data into it.
    $newWiadomosc = new Message;
    $newWiadomosc->title = $msgTitle;
    $newWiadomosc->message_body = $msgText;
    $newWiadomosc->sender_id = auth()->user()->id;
    $newWiadomosc->receiver_id = $wiadomosc->sender_id;

// Save Model data into DB.
    $saved = $newWiadomosc->save();

    if ($saved){
      $message = 'Wiadomość została wysłana.';
    }else{
      $message = 'Nie udało się wysłać twojej wiadomości.';
    }

// Check message receiver notifcation status.
// Send email to the user with notification about new message in mailbox if his notifications are turned on. Then redirect back.
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

// Delete message only in one-side user view.
  public function deleteMessage($id){
// Find Message and logged User.
    $wiadomosc = Message::find($id);
    $user_id = auth()->user()->id;
    $user = User::find($user_id);

// Check if message exist
  if($wiadomosc){
// Validate user
  if($wiadomosc->sender_id == $user_id || $wiadomosc->receiver_id == $user_id){

// Mark specified message as deleted by specified user(sender/receiver).
    if($wiadomosc->sender_id == $user_id){
      $wiadomosc->deleted_by_sender = 1;
      $wiadomosc->save();
    }elseif($wiadomosc->receiver_id == $user_id){
      $wiadomosc->deleted_by_receiver = 1;
      $wiadomosc->save();
    }

// Return back to mailbox.
    $message = 'Wiadomość została usunięta.';
    return redirect()->route('skrzynka')->with('message', $message);
    }else{
      return redirect()->back();
    }
  }else{
    return redirect()->back();
  }
}
// Mark message as not viewed.
  public function markAsNotViewed($id){
// Find Message Model.
    $wiadomosc = Message::find($id);

// Check if message exist
    if($wiadomosc){
// Validate user
    if($wiadomosc->receiver_id == auth()->user()->id){

// Check if message was viewed before. If yes change its value to false and save data.
    if($wiadomosc->viewed = true){
      $wiadomosc->viewed = false;
      $wiadomosc->save();
      $message = 'Wiadomość została oznaczona jako nieprzeczytana.';
      return redirect('/wiadomosci')->with('message', $message);
    }

// Redirect back if validation fails
    }else{
      return redirect()->back();
    }
// Redirect back if message does not exists
    }else{
      return redirect()->back();
    }
  }


// Toggle viewed status.
  public function changeViewedStatus($id){
// Find Message Model.
    $wiadomosc = Message::find($id);

// Check if message exist
    if($wiadomosc){
// Validate user
    if($wiadomosc->receiver_id == auth()->user()->id){

// If message was viewed by user mark it as not viewed before and save data.
    if($wiadomosc->viewed == true){
      $wiadomosc->viewed = false;
      $wiadomosc->save();

// If message has never been viewed change its status to viewed without opening the message.
    }elseif($wiadomosc->viewed == false){
      $wiadomosc->viewed = true;
      $wiadomosc->save();
    }
    return redirect('/wiadomosci');
// Redirect back if validation fails
    }else{
      return redirect()->back();
    }
// Redirect back if message does not exists
    }else{
      return redirect()->back();
    }
}

// // One-side elete all checked Messages.
//   public function deleteChecked(Request $request){
// // Create array that contains all checked message ids.
//       $checked = $request->input('checkedMessage');
// // Checks if $checked array contain any elements.
//       if($checked){
// // Find logged user.
//       $user_id = auth()->user()->id;
//       $user = User::find($user_id);
//
// // Move through all ids contained in $checked array.
//       foreach ($checked as $id){
// // Find Message Model.
//         $wiadomosc = Message::find($id);
//
// // Mark sended Message as deleted_by_sender only in his view - not affecting receiver view.
//         if($wiadomosc->sender_id == $user_id){
//           $wiadomosc->deleted_by_sender = 1;
//           $wiadomosc->save();
//
// // Mark received Message as deleted_by_receiver only in his view - not affecting sender view.
//         }elseif($wiadomosc->receiver_id == $user_id){
//           $wiadomosc->deleted_by_receiver = 1;
//           $wiadomosc->save();
//         }
//       }
//     }
//       return redirect()->route('skrzynka');
//   }


// Multiple options for checkbox messages form.
  public function skrzynkaOptions(Request $request){
// Find logged user.
    $user_id = auth()->user()->id;
    $user = User::find($user_id);
// Create array that contains all checked message ids.
    $checked = $request->input('checkedMessage');
// Get tab name to redirect it back to it after submitting form.
    $tab = $request->input('tabn');

// Checks if $checked array contain any elements.
    if($checked){
// Check which option user has selected.
      if($request->deletesubmit_x){
// Find all checked Messages and mark them as deleted by one-side user.
        foreach ($checked as $id){
          $wiadomosc = Message::find($id);
          if($wiadomosc){
          if($wiadomosc->sender_id == $user_id){
            $wiadomosc->deleted_by_sender = 1;
            $wiadomosc->save();
          }elseif($wiadomosc->receiver_id == $user_id){
            $wiadomosc->deleted_by_receiver = 1;
            $wiadomosc->save();
          }
          }
        }
      }elseif($request->setReaded_x){
// Find all checked Messages and change their viewed status to true.
        foreach ($checked as $id){
          $wiadomosc = Message::find($id);
          if($wiadomosc){
          if($wiadomosc->deleted_by_receiver == false){
            $wiadomosc->viewed = true;
            $wiadomosc->save();
          }
        }
        }
      }elseif($request->setUnreaded_x){
// Find all checked Messages and change their viewed status to false.
        foreach ($checked as $id){
          $wiadomosc = Message::find($id);
          if($wiadomosc){
          if($wiadomosc->deleted_by_receiver == false){
            $wiadomosc->viewed = false;
            $wiadomosc->save();
          }
        }
        }
      }
    }

// Redirect back to specified tab.
    return back()->withInput(['tab'=> $tab ]);
  }
}
