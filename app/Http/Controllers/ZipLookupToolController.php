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

        if(!property_exists($zip_response, 'places')){
            $error_message = "No result found for \"". $request->zip."\"\n";
            $saved_lookup = $zip_lookup->saveZipLookup($zip_response , $request->zip);
            return view('dashboard', [ 
                "error"=>$error_message
            ]);
        }
       
        $saved_lookup = $zip_lookup->saveZipLookup($zip_response);

        $data = json_decode($saved_lookup->data);
        
        $place = $data->places[0];
        $text  = "City: " . $place->{'place name'}. "\n";
        $text .= "State: " . $place->state. "\n";
        $text .= "Country: " . $data->country. "\n";
        $text .= "Postal code: " . $data->{'post code'}. "\n";
        $text .= "(latitude,longitude): (" . $place->latitude .",". $place->longitude . ")\n";
       
        return view('dashboard', [
            "text" => $text, 
        ]);
    }
}
