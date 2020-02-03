<?php

namespace App\Providers;

use App\Exam;
use App\Myclass;
use App\Section;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Cache;
use mysql_xdevapi\Session;

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
