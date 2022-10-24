<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ZipLookupService;

class ZipLookupToolController extends Controller
{
    //
    public function lookupZipCode(Request $request)
    {
    
        $zip_lookup_service = new ZipLookupService();

        if(!$zip_lookup_service->validateZipCode($request->zip)){
            $error_message = "Expecting US based zip code. \n";
            return view('dashboard', [ 
                "error"=>$error_message
            ]);
        }

        $zip_response = $zip_lookup_service->lookupZipCode($request->zip);

        if(!property_exists($zip_response, 'places')){
            $error_message = "No result found for \"". $request->zip."\"\n";
            $saved_lookup = $zip_lookup_service->saveZipLookup($zip_response , $request->zip);
            return view('dashboard', [ 
                "error"=>$error_message
            ]);
        }
       
        $saved_lookup = $zip_lookup_service->saveZipLookup($zip_response);

        if(!isset($saved_lookup->data)){
            return view('dashboard', [ 
                "error"=>$saved_lookup->getMessage()
            ]);
        }
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
