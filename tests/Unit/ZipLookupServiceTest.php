<?php

namespace Tests\Unit;

use App\Services\ZipLookupService;
use Tests\TestCase;

class ZipLookupServiceTest extends TestCase
{
    /**
     * Test for valid zip code return value.
     *
     * @return void
     */
    public function test_valid_zip_code_return_value()
    {
        $zip_lookup = new ZipLookupService();
        $this->assertTrue($zip_lookup->validateZipCode('00210'));
        $this->assertFalse($zip_lookup->validateZipCode('0021'));
        $this->assertFalse($zip_lookup->validateZipCode('002101'));
        $this->assertFalse($zip_lookup->validateZipCode('K2C 2V2'));
    }

    /**
     * Test for valid zip code return value.
     *
     * @return void
     */
    public function test_zip_tool_api_response()
    {
        $zip_code = '00210';
        $zip_lookup = new ZipLookupService();
        $zip_response = $zip_lookup->lookupZipCode($zip_code);
        $this->assertTrue(property_exists($zip_response, 'places'));
        $this->assertTrue($zip_response->country == 'United States');
        $this->assertTrue($zip_response->{'post code'} == $zip_code);

    }

}
