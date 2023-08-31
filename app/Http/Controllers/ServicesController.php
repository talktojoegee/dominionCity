<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    public $baseUrl;
    public function __construct(){
        $this->baseUrl = 'https://app.smartsmssolutions.com/';
        $this->adminApiToken = env('SMARTSMS_API_TOKEN');
        //$this->type = 3;
    }

    public function checkFirstDigit($number){
        $digit = substr($number, 0,1);
        if($digit == '0'){
            return '0'; //first number starts with 0
        }elseif($digit == '+'){
            return '+';
        }else{
            return 's'; //some #
        }
    }

    public function appendCountryCode($number){
        $country_code = "234";
        $phone_no = "";
        $digit = $this->checkFirstDigit($number);
        $length = strlen($number);
        if($digit == '0'){
            #Remove the 0
            $stripped_phone = substr($number,1,$length - 1);
            $phone_no = $country_code.$stripped_phone;
            return $phone_no;
        }elseif( $digit == 's'){ //2348032404359, 08032889972, 7036005031, +2349023849871
            if(substr($number,0,3) == '234'){
                return $number;
            }else{
                return $country_code.$number;
            }
        }elseif($digit == '+'){
            return substr($number,1,$length-1);
        }
    }

    public function getPhoneInfo($phoneNumbers, $type){
        //return $phoneNumbers;
        $client = new Client();
        $url = $this->baseUrl."io/api/client/v1/phone/info/?token=".$this->adminApiToken."&phone=".$phoneNumbers."&type=".$type;
        //return $url;
        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody()->getContents());
    }

    public function sendSmartSms($senderId, $to, $message, $messageType, $refId ){

        $client = new Client();
        //$current = Carbon::now();
        //return date("Y m h:i", strtotime("+30 minutes"));
        $options = [
            'multipart' => [
                [
                    'name' => 'token',
                    'contents' => $this->adminApiToken
                ],
                [
                    'name' => 'sender',
                    'contents' => $senderId
                ],
                [
                    'name' => 'to',
                    'contents' => $to
                ],
                [
                    'name' => 'message',
                    'contents' => $message
                ],
                [
                    'name' => 'type',
                    'contents' => $messageType
                ],
                [
                    'name' => 'routing',
                    'contents' => 3
                ],
                [
                    'name' => 'ref_id',
                    'contents' => Auth::user()->id
                ],
               /* [
                    'name' => 'simserver_token',
                    'contents' => 'simserver-token'
                ],
                [
                    'name' => 'dlr_timeout',
                    'contents' => 'dlr-timeout'
                ],
                [
                    'name' => 'schedule',
                    'contents' => $current->addMinutes(2)
                ]*/
            ]];
        $url = $this->baseUrl."io/api/client/v1/sms/";
        $request = new \GuzzleHttp\Psr7\Request('POST', $url);
        $res = $client->sendAsync($request, $options)->wait();
        return json_decode($res->getBody()->getContents());
    }

    public function getDeliveryReport(){

    }

    public function senderIdRequest($senderId, $message){
        $client = new Client();
        $options = [
            'multipart' => [
                [
                    'name' => 'token',
                    'contents' => $this->adminApiToken
                ],
                [
                    'name' => 'senderid',
                    'contents' => $senderId
                ],
                [
                    'name' => 'message',
                    'contents' => $message ?? 'We intend to use this sender ID to automate our business process by keeping our subscribers informed almost in real time.'
                ],
                [
                    'name' => 'organisation',
                    'contents' => Auth::user()->first_name
                ],
                [
                    'name' => 'regno',
                    'contents' => '35090835714'
                ],
                [
                    'name' => 'address',
                    'contents' => 'EFAB Mall Area 11 Garki Abuja, Nigeria'
                ]
            ]];
        $url = $this->baseUrl."io/api/client/v1/senderid/create/";
        $request = new \GuzzleHttp\Psr7\Request('POST', $url);
        $res = $client->sendAsync($request, $options)->wait();
        return json_decode($res->getBody()->getContents());
    }
}
