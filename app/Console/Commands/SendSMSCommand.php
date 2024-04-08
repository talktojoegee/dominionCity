<?php

namespace App\Console\Commands;

use App\Http\Traits\SMSServiceTrait;
use App\Models\BulkMessage;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SendSMSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bulksms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send bulk sms';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle()
    {

        $now = Carbon::now('Africa/Lagos')->toDateTimeString();
        $messages = BulkMessage::getRecurringMessages(); /*BulkMessage::whereDate('next_schedule', '=', $now)
            ->where('recurring_active','=', 1)
            ->where('recurring','=',1)->get();*/
         if(count($messages) > 0){
                 foreach($messages as $message){
                     $currentDate = new \DateTime(date("Y-m-d"));
                     $scheduledDate = new \DateTime(date("Y-m-d", strtotime($message->next_schedule)));
                     if($currentDate == $scheduledDate){
                         $currentTime = date('H:i', strtotime($now));
                         $messageTime = date('H:i', strtotime($message->next_schedule));
                         echo "\n Current Time:". $currentTime." | \t Message Time: ".$messageTime." | \t Date:".$currentDate->format('d M, Y')." | \t Status: ".($currentTime === $messageTime ? 'Same' : 'Not same');
                         if($currentTime === $messageTime){
                             $this->sendSmartSms($message->sender_id, $message->sent_to, $message->message, 1, $message->batch_code);
                             if($message->recurring == 0){
                                 $message->recurring_active = 0;
                                 $message->save();
                             }
                         }
                     }
                 }

         }

    }

    public function sendSmartSms($senderId, $to, $message, $messageType, $refId ){

        $client = new Client();
        $options = [
            'multipart' => [
                [
                    'name' => 'token',
                    'contents' => env("SMARTSMS_API_TOKEN")
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

            ]];
        $url = env("SMARTSMS_BASEURL")."io/api/client/v1/sms/";
        $request = new \GuzzleHttp\Psr7\Request('POST', $url);
        $res = $client->sendAsync($request, $options)->wait();
        return json_decode($res->getBody()->getContents());
    }
}
