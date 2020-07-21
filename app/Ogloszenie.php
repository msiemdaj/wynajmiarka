<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;

class Ogloszenie extends Model
{

  use Favoriteable;

  protected $table = 'ogloszenia';
  public $primaryKey = 'id';
  public $timestamps = true;

  public function user(){
    return $this->belongsTo('App\User');
  }
}
