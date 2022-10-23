<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class ZipLookupService
{
    /**
     * Validates the provided zip code
     *
     * @param [string] $zip_code
     * @return boolean
     */
    public function validateZipCode($zip_code){
        return (is_numeric($zip_code) || strlen($zip_code) == 5);            
    }

    /**
     * Get API response for given zip code from Zippopotam
     *
     * @param [string] $zip_code
     * @return object
     */
    public function lookupZipCode($zip_code){
        $response = Http::accept('application/json')->get("api.zippopotam.us/us/${zip_code}");
        $response = json_decode($response->getBody()->getContents());  
        return $response;
    }
}


?>