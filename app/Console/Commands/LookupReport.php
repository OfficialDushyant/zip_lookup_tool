<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use App\Mail\ActivityReport;
use App\Services\ZipLookupService;
use App\Models\User;
use Illuminate\Support\Carbon;

class LookupReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zip:report {email} {--hours=24}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will send an email report for up to the specified number of hours of zip search to the specified email.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(!filter_var( $this->argument('email'), FILTER_VALIDATE_EMAIL)) {
            $this->error("Provided email is not valid");
            return Command::FAILURE;
        }
        try {
            $data = User::whereHas('lookups', function($query){
                $query->whereBetween('created_at' , [Carbon::now()->subHours($this->option('hours')),Carbon::now()]);
            })->get();
            Mail::to($this->argument('email'))->send(new ActivityReport($data));
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
