<?php

namespace App\Providers;

use App\Event;
use App\Exam;
use App\Myclass;
use App\Notice;
use App\Section;
use App\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Resource::withoutWrapping();
        Myclass::creating(function (){
            Cache::flush();
        });
        Section::creating(function (){
            Cache::flush();
        });
        User::creating(function (){
            Cache::flush();
        });
        Exam::creating(function (){
            Cache::flush();
        });

        Myclass::deleting(function (){
            Cache::flush();
        });
        Section::deleting(function (){
            Cache::flush();
        });
        User::deleting(function (){
            Cache::flush();
        });
        Exam::deleting(function (){
            Cache::flush();
        });
        Notice::creating(function (){
            Cache::flush();
        });
        Event::creating(function (){
            Cache::flush();
        });
        Notice::deleting(function (){
            Cache::flush();
        });
        Event::deleting(function (){
            Cache::flush();
        });
        Notice::updating(function (){
            Cache::flush();
        });
        Event::updating(function (){
            Cache::flush();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
