<?php
namespace App\Helpers;

use App\Helpers\Construction\AbstractApiHelper;
use DateTimeImmutable;
use GusApi\BulkReportTypes;
use GusApi\Exception\InvalidUserKeyException;
use GusApi\Exception\NotFoundException;
use GusApi\GusApi;
use GusApi\ReportTypes;
use GusApi\SearchReport;

class GusHelper extends AbstractApiHelper {

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

       return $this->getDataFromWeb($data[key($data)], key($data));

    }

    protected function getDataFromWeb(string $number, string $type): array{
        $result = null;
        try {
            $this->GusApi->login();
            $gusReports = $this->getAppropriateFunction($number, $type);
//            var_dump($this->GusApi->dataStatus());
//            var_dump($this->GusApi->getBulkReport(
//                new DateTimeImmutable('2019-05-31'),
//                BulkReportTypes::REPORT_DELETED_LOCAL_UNITS
//            ));
//          dd($gusReports);
            /**
             * @var  SearchReport $gusReport
             */
            foreach ($gusReports as $gusReport) {
                $reportType = ReportTypes::REPORT_PUBLIC_LAW;
                $result['basic']['name'] = $gusReport->getName();
                $result['basic']['province'] = $gusReport->getProvince();
                $result['basic']['district'] = $gusReport->getDistrict();
                $result['basic']['community'] = $gusReport->getCommunity();
                $result['basic']['city'] = $gusReport->getCity();
                $result['basic']['zip'] = $gusReport->getZipCode();
                $result['basic']['street'] = $gusReport->getStreet();
                $result['basic']['propertyNumber'] = $gusReport->getPropertyNumber();
                $result['basic']['apartmentNumber'] = $gusReport->getApartmentNumber();
                $result['basic']['postCity'] = $gusReport->getPostCity();
                $result['basic']['type'] = $gusReport->getType();
                $result['basic']['regon'] = $gusReport->getRegon();
                $result['basic']['regon14'] = $gusReport->getRegon14();
                $result['basic']['nip'] = $gusReport->getNip();
                $result['basic']['nipStatus'] = $gusReport->getNipStatus();
                $result['basic']['silo'] = $gusReport->getSilo();
                $result['basic']['activityEnd'] = $gusReport->getActivityEndDate();

                $result['report'] = $this->GusApi->getFullReport($gusReport, $reportType);
            }

            return $result;
        } catch (InvalidUserKeyException $e) {
            $result['error'] = 'Bad user key';

            return $result;
        } catch (NotFoundException $e) {
            $result['error'] = 'No data found. For more information read server message below: '. $this->GusApi->getResultSearchMessage();

            return $result;
        }

    }

    protected function getAppropriateFunction(string $number, string $type): array
    {
        switch ($type){
            case GusHelper::NIP:
                return $this->GusApi->getByNip($number);
            case GusHelper::REGON:
                return $this->GusApi->getByRegon($number);
            case GusHelper::KRS:
                return $this->GusApi->getByKrs($number);
        }
    }


}
