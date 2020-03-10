<?php

namespace App\Listeners;

use App\Configuration;
use App\Events\SchoolCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateDefaultConfigurations implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SchoolCreated  $event
     * @return void
     */
    public function handle(SchoolCreated $event)
    {
        $data = [
            [
                'key' => 'last_attendance_time',
                'value' => '10:30',
                'school_id' => $event->school->id
            ],
            [
                'key' => 'exit_time',
                'value' => '15:00',
                'school_id' => $event->school->id
            ],
            [
                'key' => 'transaction_serial',
                'value' => 1,
                'school_id' => $event->school->id
            ]
        ];
        
        Configuration::insert($data);
    }
}
