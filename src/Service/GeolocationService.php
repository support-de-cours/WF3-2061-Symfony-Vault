<?php 
namespace App\Service;

class GeolocationService
{
    /**
     * Geolocation API
     * 
     * @var string
     */
    const API = "http://ip-api.com/json";

    /**
     * Country code
     *
     * @var string|null
     */
    private ?string $country = null;



    public function __construct()
    {
        // Get Location from the API
        $geodata = $this->curlRequest();

        // Set the country value
        $this->country = $geodata->countryCode;
    }



    /**
     * Get the country code
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Execute a cURL Request and return the API Response
     *
     * @return \stdClass
     */
    private function curlRequest(): \stdClass
    {
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::API );
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($ch);

        curl_close($ch);
        
        return json_decode($data);
    }
}