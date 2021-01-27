<?php

namespace App\Console\Commands;

use App\OnlineClassSchedule;
use App\OnlineClassSummary;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OnlineClassNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sent:online-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sent online notification when its schedule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        logger('Sent online notification job run');

        $items = OnlineClassSchedule::with('students')->where('status', true)->get();

        foreach ($items as $item) {

            $time_now = Carbon::now()->format('H:i');
            $notification_time = Carbon::parse($item->notification_time)->format('H:i');
            $dayOfWeek = $dayOfTheWeek = Carbon::now()->dayOfWeek;

            if ($item->is_everyday == true && $time_now == $notification_time) {
                logger('in the everyday section');

                logger($item->id);
                logger(Carbon::now());
                logger($time_now);
                logger($item->notification_time);
                logger($notification_time);

                $summary = new OnlineClassSummary();
                $summary->class_schedules_id = $item->id;
                $summary->total_sms = count($item->students);
                $summary->save();

                return;
            }
            if ($item->is_repeatable == true && $dayOfWeek === $item->week_day && $time_now == $notification_time) {

                logger('in the repeatable section');

                $summary = new OnlineClassSummary();
                $summary->class_schedules_id = $item->id;
                $summary->total_sms = count($item->students);
                $summary->save();

                return;
            }

            logger('No data found for sent sms');
        }

        logger('Sent online notification job close');
    }
}
