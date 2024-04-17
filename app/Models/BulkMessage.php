<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BulkMessage extends Model
{
    use HasFactory;

    public function setNewMessage($msg, $phone_numbers, $senderId, $status, $startDate,
                                  $endDate, $frequency, $recurring, $phoneGroup){
        $batchCode = Str::random(11);
        $message = new BulkMessage();
        $message->user_id = Auth::user()->id;
        $message->sent_by = Auth::user()->id;
        $message->sender_id = $senderId;
        $message->status = $status;
        $message->slug = substr(sha1(time()),23,40);
        $message->message = $msg;
        $message->sent_to = $phone_numbers;
        $message->batch_code = $batchCode;
        $message->bulk_frequency = $frequency;
        $message->recurring_active = 1;
        $message->recurring = $recurring;
        $message->next_schedule = $endDate;
        $message->start_date = $startDate;
        $message->phone_group = $phoneGroup ?? null;
        $message->save();
    }

    public function getTenantMessages(){
        return BulkMessage::where('tenant_id', Auth::user()->tenant_id)->orderBy('id', 'DESC')->get();
    }

    public function getTenantMessageBySlug($slug){
        return BulkMessage::where('tenant_id', Auth::user()->tenant_id)->where('slug', $slug)->first();
    }

    public static function getRecurringMessages(){

        return BulkMessage::where("recurring", 1)/*->where("recurring_active",1)*/->orderBy('id', 'DESC')->get();
    }
}
