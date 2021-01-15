<?php

namespace App\Helpers;




use GuzzleHttp\Client;

class GuzzleHelper {
    private $base_url = 'https://rejestr.io';
    private $clientHttp;

    public function __construct()
    {
        $key = env('KRS_KEY');
        $this->clientHttp = new Client([
            'base_uri' =>  $this->clientHttp,
            'headers' => ['Authorization' => $key],
        ]);


    }

    public function getDataByQuery(){
        return $this->clientHttp->get('/api/v1/krs', [
            'query' => ['nip' => 7133100359]
        ]);

    }
}
