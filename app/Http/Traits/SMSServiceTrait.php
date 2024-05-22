<?php
namespace App\Http\Traits;


use App\Models\BulkSmsAccount;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

trait SMSServiceTrait{

  /*  public $baseUrl, $adminApiToken;
    public function __construct(){
        $this->baseUrl = 'https://app.smartsmssolutions.com/';
        $this->adminApiToken = env('SMARTSMS_API_TOKEN');
    }*/

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
        $url = env('SMARTSMS_BASEURL')."io/api/client/v1/phone/info/?token=".env('SMARTSMS_API_TOKEN')."&phone=".$phoneNumbers."&type=".$type;
        //return $url;
        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody()->getContents());
    }

    public function sendSmartSms($senderId, $to, $message, $messageType, $refId ){

        $client = new Client();
        $options = [
            'multipart' => [
                [
                    'name' => 'token',
                    'contents' => env('SMARTSMS_API_TOKEN')
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
                    'contents' => 1,//Auth::user()->id
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
        $url = env('SMARTSMS_BASEURL')."io/api/client/v1/sms/";
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
                    'contents' => env('SMARTSMS_API_TOKEN')
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
                    'contents' => 'John Doe',//Auth::user()->first_name
                ],
                [
                    'name' => 'regno',
                    'contents' => '35090835714'
                ],
                [
                    'name' => 'address',
                    'contents' => 'Abuja, Nigeria'
                ]
            ]];
        $url = env('SMARTSMS_BASEURL')."io/api/client/v1/senderid/create/";
        $request = new \GuzzleHttp\Psr7\Request('POST', $url);
        $res = $client->sendAsync($request, $options)->wait();
        return json_decode($res->getBody()->getContents());
    }


    public function getBulkSMSCharge($list, $message, $maxBatch){
        $filter = array_unique($list);
        //$phone_numbers = implode(",",$filter);
        //$persons = count($filter);
        $no_of_pages = $this->getNumberOfPages($message);

        $dnd = 0;
        $ndnd = 0;
        $counter = $this->getCounterBatch($filter, $maxBatch);
        for($i = 0; $i < $counter; $i++){
            $slice = array_slice($filter,($maxBatch * $i),$maxBatch);
            $implodeSlice = implode(",",$slice);
            $sortedPhoneNumbers = $this->getPhoneInfo($implodeSlice, 3); //$this->service->getPhoneInfo($implodeSlice, 3);
            $data = $sortedPhoneNumbers->data;
            /*
             * Sort phone numbers according to network and DND status
             */
            $airTelNonDndArray  = $data->{'airtel non-dnd'} ?? [];
            $airTelDndArray  = $data->{'airtel dnd'} ?? [];
            //$airtelCost += ($no_of_pages * 3.5 * count($airTelNonDndArray)) + ($no_of_pages * 5 * count($airTelDndArray));

            $mtnNonDndArray  = $data->{'mtn non-dnd'} ?? [];
            $mtnDndArray  = $data->{'mtn dnd'} ?? [];
            //$mtnCost += ($no_of_pages * 3.5 * count($mtnNonDndArray)) + ($no_of_pages * 5 * count($mtnDndArray));

            $gloNonDndArray = $data->{'glo non-dnd'} ?? [];
            $gloDndArray = $data->{'glo dnd'} ?? [];
            //$gloCost += ($no_of_pages * 3.5 * count($gloNonDndArray)) + ($no_of_pages * 5 * count($gloDndArray));

            $mobileNonDndArray = $data->{'9mobile non-dnd'} ?? [];
            $mobileDndArray = $data->{'9mobile dnd'} ?? []; //9mobile
            //$mobileCost += ($no_of_pages * 3.5 * count($mobileNonDndArray)) + ($no_of_pages * 5 * count($mobileDndArray));

            $dnd += (count($airTelDndArray) + count($mtnDndArray) + count($gloDndArray) + count($mobileDndArray));
            $ndnd += (count($airTelNonDndArray) + count($mtnNonDndArray) + count($gloNonDndArray) + count($mobileNonDndArray));

            $unknown = $airtelNonDnd = $data->{'unknown non-dnd'} ?? [];

        }
        return (($dnd * 5) * $no_of_pages) + (($ndnd * 3.5) * $no_of_pages);
    }

    public function getNumberOfPages($message){
        $perPage = 160;
        return round(strlen($message)/$perPage) < 1 ? 1 : round(strlen($message)/$perPage);
        //max(round(strlen($message) / $perPage), 1);
    }


    public function getCounterBatch($filter, $maxBatch){
        return round(count($filter)/$maxBatch) <= 0 ? 1 : round(count($filter)/$maxBatch);
    }


    public function getWalletBalance(){
        $wallet = BulkSmsAccount::all();
        return $wallet->sum('credit') - $wallet->sum('debit');
    }



}

?>
