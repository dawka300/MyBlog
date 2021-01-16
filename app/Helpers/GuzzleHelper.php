<?php

namespace App\Helpers;




use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class GuzzleHelper {
    private $base_url = 'https://rejestr.io';
    private $clientHttp;

    public function __construct()
    {
        $key = env('KRS_KEY');
        $this->clientHttp = new Client([
            'base_uri' =>  $this->base_url,
            'headers' => ['Authorization' => $key],
        ]);


    }

    public function search(array $request) {
        foreach ($request as $key => $value) {
            if(!empty($value) && $key !== 'krs') {
                return $this->getDataByQuery($key, (string)$value);
            }elseif(!empty($value) && $key === 'krs') {
                $number = (int)$value['number'];
                switch($value['type']){
                    case 'relations':
                        return $this->getRelations((string)$number);
                    case 'entries':
                        return $this->getEntries((string)$number);
                    default:
                        return $this->getByKrs((string)$value['number']);
                }
            }else {
                $message['error'] = 'Nie ma takiego pola';

                return $message;
            }
        }

    }

    public function getDataByQuery(string $arg, string $value){
        $response = $this->clientHttp->get( '/api/v1/krs', [
            'query' => [$arg => $value]
        ]);
        $response = json_decode($response->getBody()->getContents());

        return $response->items[0];
    }

    public function getByKrs(string $number) {
        $response = $this->clientHttp->get( '/api/v1/krs/'.$number);

        return $this->responseConvert($response);
    }

    public function getRelations(string $number) {
        $response = $this->clientHttp->get( '/api/v1/krs/'.$number.'/relations');

        return $this->responseConvert($response);
    }

    public function getEntries(string $number) {
        $response = $this->clientHttp->get( '/api/v1/krs/'.$number.'/entries');

        return $this->responseConvert($response);
    }

    // Pobieranie odpisu KRS - dla konta premium
    public function getExtract(string $number) {
        $response = $this->clientHttp->get( '/api/v1/krs/'.$number.'/extract');

        return $this->responseConvert($response);
    }


    public function getPerson(string $id) {
        $response = $this->clientHttp->get( '/api/v1/persons/'.$id);

        return $this->responseConvert($response);
    }

    public function getPersonRelations(string $id) {
        $response = $this->clientHttp->get( '/api/v1/persons/'.$id.'/relations');

        return $this->responseConvert($response);
    }

    //Pobieranie stanu konta
    public function getAccount() {
        $response = $this->clientHttp->get( '/api/v1/account/balance');

        return $response->getBody()->getContents();
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function responseConvert($data) {
        return json_decode($data->getBody()->getContents());
    }
}
