<?php

namespace App\Console\Commands;
use App\Services\ZipLookupService;

use Illuminate\Console\Command;
use Psy\Readline\Hoa\Console;

class ZipLookup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zip:lookup {zip : US zip code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make request to Zippopotam for provided zip code.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $zip_lookup = new ZipLookupService();
        if($zip_lookup->validateZipCode($this->argument('zip'))){
            $this->error("Expecting US based zip code.");
            return;
        }


        $zip_response = $zip_lookup->lookupZipCode($this->argument('zip'));

        if(!property_exists($zip_response, 'places')){
            $this->error("No result found for ". $this->argument('zip'));
            return;
        }

        $place = $zip_response->places[0];
        $this->newLine();
        $this->line('Zippopotam response for '. $zip_response->{'post code'});
        $this->newLine();
        $console_display  = "Postal code: " . $zip_response->{'post code'}. "\n";
        $console_display .= "Country: " . $zip_response->country. "\n";
        $console_display .= "Place: " . $place->{'place name'}. "\n";
        $console_display .= "State: " . $place->state. "\n";
        $console_display .= "(latitude,longitude): (" . $place->latitude .",". $place->longitude . ")\n";

       $this->info($console_display);
    }
}
