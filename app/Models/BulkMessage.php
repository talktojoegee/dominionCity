<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BulkMessage extends Model
{
    use HasFactory;

    public function setNewMessage($msg, $phone_numbers, $senderId){
        $batchCode = Str::random(11);
        $message = new BulkMessage();
        $message->user_id = Auth::user()->id;
        $message->sent_by = Auth::user()->id;
        $message->sender_id = $senderId;
        $message->status = 1;
        $message->slug = substr(sha1(time()),23,40);
        $message->message = $msg;
        $message->sent_to = $phone_numbers;
        $message->batch_code = $batchCode;
        $message->save();
    }

    public function getTenantMessages(){
        return BulkMessage::where('tenant_id', Auth::user()->tenant_id)->orderBy('id', 'DESC')->get();
    }

    public function getTenantMessageBySlug($slug){
        return BulkMessage::where('tenant_id', Auth::user()->tenant_id)->where('slug', $slug)->first();
    }
}
