<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Lookups;
use App\Models\User;

class ZipLookupService
{
    /**
     * Validates the provided zip code
     *
     * @param [string] $zip_code
     * @return boolean
     */
    public function validateZipCode($zip_code){
        return (is_numeric($zip_code) && strlen($zip_code) == 5);            
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

    /**
     * Saves the lookup data in to lookups table
     *
     * @param [object] $response_data
     * @param [string] $searched_zip
     * @return mixed
     */
    public function saveZipLookup($response_data , $searched_zip = null)
    {   $user_id = auth()->user()->id;

        $lookups = new Lookups();

        try {
            $lookups->user_id = $user_id;
            $lookups->zip = isset($response_data->{'post code'}) ? $response_data->{'post code'} : $searched_zip ;
            $lookups->valid_response = property_exists($response_data, 'places');
            $lookups->data = json_encode($response_data);
            $lookups->save();
            return $lookups;

        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $e;
        }
    }
}


?>