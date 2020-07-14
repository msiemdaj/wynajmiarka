<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;
use App\Message;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('includes/header', function($view){
          if(Auth::check()){
          $user_id = auth()->user()->id;
          $msgCount = Message::where('receiver_id', $user_id)
                              ->where('viewed', false)
                              ->where('deleted_by_receiver', false)
                              ->count();
          $view->with('msgCount', $msgCount);
        }
      });
    }
}
