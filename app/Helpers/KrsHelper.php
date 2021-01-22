<?php

namespace App\Helpers;




use App\Helpers\Construction\AbstractApiHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class KrsHelper extends AbstractApiHelper {
    const ERRORS = [
        '400' => 'Niepoprawne zapytanie',
        '401' => 'Klucz API nie został podany lub jest nieważny.',
        '403' => 'Przekroczono liczbę opłaconych zapytań API.',
        '404' => 'Żądany obiekt nie został znaleziony - sprawdź wprowadzony numer!',
        '429' => 'Przekroczono liczbę zapytań API na minutę.',
        '500' => 'Wewnętrzny błąd serwera.'
    ];

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
            if(!empty($value) && $key !== self::KRS && in_array($key, self::AVAILABLE_VALUES)) {
                return $this->getDataByQuery($key, (string)$value);
            }elseif(!empty($value) && $key === self::KRS) {
                $number = (int)$value['number'];

                switch ($value['type']) {
                    case 'relations':
                        return $this->getRelations((string)$number);
                    case 'entries':
                        return $this->getEntries((string)$number);
                    default:
                        return $this->getByKrs((string)$value['number']);
                }

            }elseif(!in_array($key, self::AVAILABLE_VALUES)) {
                $message['error'] = self::ERRORS['400'];

                return $message;
            }
        }

    }

    public function getDataByQuery(string $arg, string $value){
        try {
            $response = $this->clientHttp->get('/api/v1/krs', [
                'query' => [$arg => $value]
            ]);
            $response = json_decode($response->getBody()->getContents());
            if(!empty($response->items)){
                return $response->items[0];
            }else{
                return ['error' => self::ERRORS['404']];
            }

        } catch (GuzzleException $e) {
            return $this->errorHandling($e);
        }
    }

    public function getByKrs(string $number) {
        try {
            $response = $this->clientHttp->get( '/api/v1/krs/'.$number);

            return $this->responseConvert($response);
        }catch (GuzzleException $e){
            return $this->errorHandling($e);
        }

    }

    public function getRelations(string $number) {
        try {
            $response = $this->clientHttp->get('/api/v1/krs/' . $number . '/relations');

            return $this->responseConvert($response);
        } catch (GuzzleException $e) {
            return $this->errorHandling($e);
        }
    }

    public function getEntries(string $number) {
        try {
            $response = $this->clientHttp->get('/api/v1/krs/' . $number . '/entries');

            return $this->responseConvert($response);
        } catch (GuzzleException $e) {
            return $this->errorHandling($e);
        }
    }

    // Pobieranie odpisu KRS - dla konta premium
    public function getExtract(string $number) {
        try {
            $response = $this->clientHttp->get('/api/v1/krs/' . $number . '/extract');

            return $this->responseConvert($response);
        } catch (GuzzleException $e) {
            return $this->errorHandling($e);
        }
    }


    public function getPerson(string $id) {
        try {
            $response = $this->clientHttp->get('/api/v1/persons/' . $id);

            return $this->responseConvert($response);
        } catch (GuzzleException $e) {
            return $this->errorHandling($e);
        }
    }

    public function getPersonRelations(string $id) {
        try {
            $response = $this->clientHttp->get('/api/v1/persons/' . $id . '/relations');

            return $this->responseConvert($response);
        } catch (GuzzleException $e) {
            return $this->errorHandling($e);
        }
    }

    //Pobieranie stanu konta
    public function getAccount() {
        try {
            $response = $this->clientHttp->get('/api/v1/account/balance');

            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            return $this->errorHandling($e);
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function responseConvert($data) {
        return json_decode($data->getBody()->getContents());
    }

    protected function errorHandling(GuzzleException $e): array
    {
        $response['error'] = 'Wystąpił błąd: '.self::ERRORS[$e->getCode()];

        return $response;
    }
}
