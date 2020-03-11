<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserRegistered' => [
            'App\Listeners\SendWelcomeEmail',
        ],
        'App\Events\StudentInfoUpdateRequested' => [
            'App\Listeners\UpdateStudentInfo',
        ],
        'App\Events\AttendanceCreated' => [
            'App\Listeners\SendAttendanceSms',
        ],
        'App\Events\SchoolCreated' => [
            'App\Listeners\CreateDefaultConfigurations',
        ],
        'App\Events\ImportStudentAttendance' => [
           'App\Listeners\AttendanceInfoStore',
        ],
        'App\Events\NewUserRegistered' => [
            'App\Listeners\AttendanceStore',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
