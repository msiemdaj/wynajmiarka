<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{


  protected $table = 'messages';
  public $primaryKey = 'id';
  public $timestamps = false;

  protected $fillable = [
      'title', 'message_body', 'sender_id', 'receiver_id',
  ];

  // public function users()
  // {
  //     return $this->belongsTo('App\User');
  // }

  public function user()
  {
      return $this->belongsTo('App\User');
  }

}
