<?php

namespace App\Console;
use App\Models\Registration;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            $url = "localhost:3000/registrations";
            $response = \Httpful\Request::get($url)
                ->addHeader('Authorization', 'token')
                ->send();
            if ($response->code >= 200 and $response->code < 400) {
                $data = $response->body->data;               
                foreach($response->body->data->pendaftaran as $x) {
                    if(empty(Registration::where("registration_id",$x->no_pendaftaran)->first())) {
                        Registration::create([
                            "registration_id" => $x->no_pendaftaran,
                            "patient_id" => $x->pasien->no_rm,
                        ]);
                    }
                }
            }
        })->everyMinute();
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
