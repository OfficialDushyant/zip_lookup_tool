<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ZipLookupService;

class ZipLookupToolController extends Controller
{
    //
    public function lookupZipCode(Request $request)
    {
    
        $zip_lookup = new ZipLookupService();
        if(!$zip_lookup->validateZipCode($request->zip)){
            $error_message = "Expecting US based zip code. \n";
            return view('dashboard', [ 
                "error"=>$error_message
            ]);
        }


        $zip_response = $zip_lookup->lookupZipCode($request->zip);
        if(property_exists($zip_response, 'places')){
            $place = $zip_response->places[0];

            $text  = "City: " . $place->{'place name'}. "\n";
            $text .= "State: " . $place->state. "\n";
            $text .= "Country: " . $zip_response->country. "\n";
            $text .= "Postal code: " . $zip_response->{'post code'}. "\n";
            $text .= "(latitude,longitude): (" . $place->latitude .",". $place->longitude . ")\n";
        }
        else{
            $error_message = "No result found for \"". $request->zip."\"\n";
            return view('dashboard', [ 
                "error"=>$error_message
            ]);
        }
       

        $zip_lookup->saveZipLookup($zip_response);
        
        return view('dashboard', [
            "text" => $text, 
        ]);
    }
}
