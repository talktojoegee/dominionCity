<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ServicesController;
use App\Http\Traits\SMSServiceTrait;
use App\Models\BulkMessage;
use App\Models\BulkSmsAccount;
use App\Models\CashBookAccount;
use App\Models\PhoneGroup;
//use App\Models\Tenant;
use App\Models\SenderId;
use App\Models\TransactionCategory;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yabacon\Paystack;
use Yabacon\Paystack\Fee;

class SMSController extends Controller
{
    use SMSServiceTrait;

    public $api;
    public $baseUrl;
    public $apiToken;
    /*public $airTelNonDndArray = [], $airTelDndArray = [];
    public $mtnNonDndArray = [], $mtnDndArray = [];
    public $gloNonDndArray = [], $gloDndArray = [];
    public $mobileNonDndArray = [], $mobileDndArray = []; //9mobile*/
    public function __construct()
    {
        $this->adminApiToken = env('SMARTSMS_API_TOKEN'); //"AFlh8eh7ALXfcRxt7RWshxUKt5BrMVtMyvtFfPXO19uQeb4GaNhpEIHHRerm";
        $this->baseUrl = 'https://app.smartsmssolutions.com/';
        $this->apiToken = 'HelloWorld';

        //$this->middleware('auth');
        $this->bulksmsaccount = new BulkSmsAccount();
        $this->phonegroup = new PhoneGroup();
        $this->bulkmessage = new BulkMessage();
        $this->service = new ServicesController();
        $this->senderid = new SenderId();

        $this->cashbookaccounts = new CashBookAccount();
        $this->transactioncategory = new TransactionCategory();

    }

    public function showPhoneGroupForm(){

        return view('bulksms.phone-groups',[
            'groups'=>$this->phonegroup->getAllUserPhoneGroups()
        ]);
    }

    public function setNewPhoneGroup(Request $request){
        $this->validate($request,[
            'group_name'=>'required',
            'phone_numbers'=>'required'
        ],[
            'group_name.required'=>'Enter a phone group name',
            'group_name.unique'=>"There's an existing phone group with this name",
            'phone_numbers.required'=>'Enter phone numbers'
        ]);
        $filtered_numbers = [];
        $phone_number_array = preg_split("/, ?/",$request->phone_numbers);
        for($i = 0; $i<count($phone_number_array); $i++){
            $number = $this->appendCountryCode($phone_number_array[$i]);
            array_push($filtered_numbers,str_replace(' ', '', $number));
        }
        $filter = array_unique($filtered_numbers);
        $phone_numbers = implode(",",$filter);
        $this->phonegroup->setNewPhoneGroup($request, $phone_numbers);
        session()->flash("success", "Your phone group was successfully published.");
        return back();
    }

    public function updatePhoneGroup(Request $request){
        $this->validate($request,[
            'group_name'=>'required',
            'phone_numbers'=>'required',
            'group'=>'required'
        ],[
            'group_name.required'=>'Enter a phone group name',
            'group_name.unique'=>"There's an existing phone group with this name",
            'phone_numbers.required'=>'Enter phone numbers'
        ]);
        $filtered_numbers = [];
        $phone_number_array = preg_split("/, ?/",$request->phone_numbers);
        for($i = 0; $i<count($phone_number_array); $i++){
            $number = $this->appendCountryCode($phone_number_array[$i]);
            array_push($filtered_numbers,$number);
        }
        $filter = array_unique($filtered_numbers);
        $phone_numbers = implode(",",$filter);
        $this->phonegroup->updatePhoneGroup($request, $phone_numbers);
        session()->flash("success", "Your changes were saved.");
        return back();
    }

    public function showTopUpForm(){
        $branchId = Auth::user()->branch;
        return view('bulksms.top-up',[
            'transactions'=>$this->bulksmsaccount->getBulkSmsTransactions(),
            'accounts'=>$this->cashbookaccounts->getBranchAccounts($branchId),
            'categories'=>$this->transactioncategory->getBranchCategoriesByType($branchId, 2),
        ]);
    }

    public function processTopUpRequest(Request $request){
        $this->validate($request,[
            'amount'=>'required',
            'expenseCategory'=>'required',
            'account'=>'required',
        ],[
            'amount.required'=>"How much will you like to add?" ,
            'expenseCategory.required'=>"Select an expense category" ,
            'account.required'=>"Which account is funding this purchase?" ,
        ]);
        try{
            $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'));
            $cost = $request->amount;
            $builder = new Paystack\MetadataBuilder();
            $builder->withCost($cost);
            $builder->withUser(Auth::user()->id);
            /*
             * Transaction Type:
             *  1 = New tenant subscription
             *  2 = Subscription Renewal
             *  3 = Invoice Payment
             *  4 = SMS Top-up
             */
            $builder->withTransaction(4);
            $builder->withAccount($request->account);
            $builder->withCategory($request->expenseCategory);
            $metadata = $builder->build();
            $charge = $cost < 2500 ? ceil($cost*1.7/100) : ceil($cost*1.7/100)+100;
            $tranx = $paystack->transaction->initialize([
                'amount'=>($cost+$charge)*100,       // in kobo
                'email'=>Auth::user()->email,
                'reference'=>substr(sha1(time()),23,40),
                'metadata'=>$metadata
            ]);
            return redirect()->to($tranx->data->authorization_url)->send();
        }catch (Paystack\Exception\ApiException $exception){
            session()->flash("error", "Whoops! Something went wrong. Try again.");
            return back();
        }
    }

    public function showTopUpTransactions(){
        return view('bulksms.top-up-transactions');
    }

    public function showComposeMessageForm(){
        //if(empty(Auth::user()->getUserPhoneGroups->count() <= 0 )){
            //session()->flash("error", "You'll need to quickly setup your <strong>sender ID</strong> in order to use this service. Click the <strong>Bulk SMS</strong> tab below.");
            //return redirect()->route('create-senders');
        //}else{
            return view('bulksms.compose-sms',[
                'phonegroups'=>$this->phonegroup->getAllUserPhoneGroups()
            ]);
        //}
    }

    public function previewMessage(Request $request){
        $this->validate($request, [
            'message'=>'required',
            'senderId'=>'required'
        ],[
            'message.required'=>'Enter the content of your message in the box provided above.',
            'senderId.required'=>'Select sender ID'
        ]);
        $list = [];
        if(empty($request->phonegroup) && empty($request->phone_numbers)){
            session()->flash("error", "Whoops! Kindly select the source of your contact or enter phone numbers in the box provided; separating them with comma.");
            return back();
        }else{
            #Phonegroup
            if(!empty($request->phonegroup)){
                $phonegroups = $this->phonegroup->getPhoneGroupArrayById($request->phonegroup);
                $contact_array = [];
                foreach ($phonegroups as $phonegroup ){
                    $ex = explode(",", $phonegroup->phone_numbers);
                    for($i = 0; $i<count($ex); $i++){
                        array_push($list, str_replace(' ','',$ex[$i]));
                    }
                }
            }
            #Phone numbers
            if(!empty($request->phone_numbers)){
                $filtered_numbers = [];
                $phone_number_array = preg_split("/, ?/",$request->phone_numbers);
                for($i = 0; $i<count($phone_number_array); $i++){
                    $number = $this->appendCountryCode($phone_number_array[$i]);
                    array_push($list,str_replace(' ', '', $number));
                }
            }
            $filter = array_unique($list);
            $phone_numbers = implode(",",$filter);
            $persons = count($filter);
            $no_of_pages = round(strlen($request->senderId.":".$request->message)/160) < 1 ? 1 : round(strlen($request->senderId.":".$request->message)/160);
            /*$cost = round($no_of_pages*3*$persons);
            $grandTotal = 0;
            $airtelCost = 0;
            $mtnCost = 0;
            $gloCost = 0;
            $mobileCost = 0;*/
            $dnd = 0;
            $ndnd = 0;

            try{
                $batchMax = 500;
                //$counter = round(count($filter)/$batchMax);
                $counter = round(count($filter)/$batchMax) <= 0 ? 1 : round(count($filter)/$batchMax);
                for($i = 0; $i < $counter; $i++){
                    $slice = array_slice($filter,($batchMax * $i),$batchMax);
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
                $grandTotal = (($dnd * 5) * $no_of_pages) + (($ndnd * 3.5) * $no_of_pages);

                return view('bulksms.preview-message',[
                    'cost'=>$grandTotal,
                    'persons'=>$persons,
                    'transactions'=>$this->bulksmsaccount->getBulkSmsTransactions(),
                    'pages'=>$no_of_pages,
                    'message'=>$request->message,
                    'phone_numbers'=>$phone_numbers,
                    'senderId'=>$request->senderId
                ]);
            }catch (\Exception $exception){
                return dd($exception->getMessage());
            }

        }

    }

    public function sendTextMessage(Request $request){
        $this->validate($request,[
            'message'=>'required',
            'cost'=>'required',
            'pages'=>'required',
            'persons'=>'required',
            'phone_numbers'=>'required',
            'senderId'=>'required'
        ]);
        try {
            //return dd($request->all());
            $senderId = $request->senderId;
            $units = round($request->persons);
            //$url = "https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=".$this->api."&from=JAG&to=".$request->phone_numbers."&body=".$request->message."&dnd=2";
            //$client = new Client();
            //$response = $client->get($url);
            //$senderId, $to, $message, $messageType = 0, $refId
            //$send = $this->service->sendSmartSms($senderId, $request->phone_numbers, $senderId.":".$request->message, 0, Auth::user()->id);
            //return dd($send->code);
            //if(!empty($send->code == 1000)){
                $this->bulksmsaccount->debitAccount(substr(sha1(time()),27,40), $request->cost, $units);
                $this->bulkmessage->setNewMessage($request->message, $request->phone_numbers, $senderId);
                session()->flash("success", "Your text message was sent successfully. Currently awaiting delivery.");
                return redirect()->route('compose-sms');
            /*}else{
                session()->flash("error", "Something went wrong. Please try again later or contact admin.");
                return redirect()->route('compose-sms');
            }*/
        }catch (\Exception $exception){
            session()->flash("error", "Something went wrong. Please try again later or contact admin.".$exception);
            return redirect()->route('compose-sms');
        }

    }


    public function showScheduleSmsForm(){
        return view('bulksms.schedule-sms');
    }

    public function showApiInterface(){
        return view('bulksms.api-settings');
    }
    public function getBulkMessages(){
        return view('sms.bulk-messages',[
            'messages'=>$this->bulkmessage->getTenantMessages()
        ]);
    }

    public function viewBulkMessage($slug){
        $message = $this->bulkmessage->getTenantMessageBySlug($slug);
        if(!empty($message)){
            return view('bulksms.view-bulk-sms', ['message'=>$message]);
        }else{
            session()->flash("error", "No record found.");
            return back();
        }
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

    public function showSenderIdForm(){
        return view('bulksms.create-sender');
    }

    public function createSenderId(Request $request){
        $this->validate($request,[
            'sender_id'=>'required',
            'purpose'=>'required'
        ],[
            'sender_id.required'=>'Enter sender ID',
            'purpose.required'=>"Enter a brief description of what you'll be using this sender ID to do."
        ]);
        $this->senderid->createSenderId($request);
        try{
            $this->senderIdRequest($request->sender_id, $request->purpose);
            //$this->service->senderIdRequest($request->sender_id, $request->purpose);
        }catch (\Exception $ex){

        }
        session()->flash("success", "Sender ID registered. You can use <strong>SMS Channel</strong> to send bulk SMS while you wait for your sender ID to be approved.");
        return back();
    }

    public function showRegisteredSenderIds(){
        return view('bulksms.all-sender-ids');
    }

    public function batchReport(){
        return view('bulksms.batch-report');
    }
}
