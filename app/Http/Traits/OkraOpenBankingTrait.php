<?php
namespace App\Http\Traits;

trait OkraOpenBankingTrait{

    public $secret = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI2NGVmMDE5NTYwMDljMDYyYmVjMWRlNGQiLCJpYXQiOjE2OTMzODUxMDl9.Ihs0Co31d8wuOrSahRL_iq00ragoDEMhRZcz-XwK-yo";

    public function okraAuth(){

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.okra.ng/v2/income/getByDate', [
            'form_params' => [
                'from' => '01-01-2020',
                'to' => '03-03-2020',
                'version' => '2'
            ],
            'headers' => [
                'accept' => 'application/json; charset=utf-8',
                'authorization' => "Bearer {$this->secret}",
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        echo $response->getBody();
    }


    public function getAllIncome(){
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.okra.ng/v2/income/getAll', [
            'body' => '{"page":"string","limit":"string","version":"string"}',
            'headers' => [
                'accept' => 'application/json; charset=utf-8',
                'authorization' => "Bearer {$this->secret}",
                'content-type' => 'application/json',
            ],
        ]);

        echo $response->getBody();
    }

    public function getIncomeByDate(){
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.okra.ng/v2/income/getByDate', [
            'headers' => [
                'accept' => 'application/json; charset=utf-8',
                'authorization' => "Bearer {$this->secret}",
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        echo $response->getBody();
    }



    public function checkBalance(){
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.okra.ng/v2/balance/check', [
            'body' => '{"account_id":"// account_id","record_id":"// record id"}',
            'headers' => [
                'authorization' => "Bearer {$this->secret}",
                'content-type' => 'application/json',
            ],
        ]);

        echo $response->getBody();
    }

    public function checkBalanceByDate($from, $to, $page=1, $limit=1){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.okra.ng/v2/balance/getByDate', [
            'form_params' => [
                'from' => $from, //'2020-04-25'
                'to' => $to, //'2020-06-29'
                'page' => $page,
                'limit' => $limit,
                'includePeriodic' => false
            ],
            'headers' => [
                'accept' => 'application/json; charset=utf-8',
                'authorization' => "Bearer {$this->secret}",
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        echo $response->getBody();
    }
}
