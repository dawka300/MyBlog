<?php
namespace App\Helpers;

use GusApi\BulkReportTypes;
use GusApi\Exception\InvalidUserKeyException;
use GusApi\Exception\NotFoundException;
use GusApi\GusApi;
use GusApi\ReportTypes;

class GusHelper {
    const NIP = 'nip';
    const REGON = 'regon';
    const KRS = 'krs';

    protected $key;
    protected $GusApi = null;

    public function __construct(){
        $this->key = env('GUS_KEY');
        $this->GusApi = new GusApi($this->key);
    }

    public function search(array $request){
        $data = null;
        foreach ($request as $key => $value){
            if(!empty($value)){
                $data[$key] = $value;
            }
        }

        switch (key($data)){
            case GusHelper::NIP:
                return $this->getDataByNip($data[GusHelper::NIP]);
            case GusHelper::REGON:
                $this->getDataByRegon($data[GusHelper::REGON]);
                break;
            case GusHelper::KRS:
                $this->getDataByKrs($data[GusHelper::KRS]);
                break;
            default:
                return 23;
        }

    }

    protected function getDataByNip(int $number){
        $this->GusApi->login();
        $gusReports = $this->GusApi->getByNip($number);
        return $number*2;

    }
    protected function getDataByRegon(int $number){
        $this->GusApi->login();
        $gusReport = $this->GusApi->getByRegon($number);

    }
    protected function getDataByKrs(int $number){
        $this->GusApi->login();

    }

}
