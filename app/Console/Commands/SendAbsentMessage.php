<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\SchoolAbsent;
use App\Configuration;
use Illuminate\Console\Command;
use App\Jobs\AbsentMessageProcess;

class SendAbsentMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absent:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send absent message';

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
        Logger('Command run');

        $configs = Configuration::where('key', 'last_attendance_time')->get();

        // Logger($configs[0]->value);

        $now = Carbon::now();

        // Logger('carbon ' . $parsedTime);

        // return;

        foreach($configs as $config) {

            $absent = SchoolAbsent::whereDate('created_at', Carbon::today())->where('school_id', $config->school_id)->first();

            if ($now->gt(Carbon::parse($config->value))) {
                if (!$absent || $absent->status == false) {
                    AbsentMessageProcess::dispatch($config->school_id);
                } else {
                    Logger('Absent sms already sent');
                }
                
            } else {
                Logger('Not in proper time');
            }
            
        }
    }
}
