<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;



    public function getAllOrgMessages(){
        return Message::where('org_id', Auth::user()->org_id)->orderBy('id', 'DESC')->get();
    }

    public function saveMessage(Request $request){
        $message = new Message();
        $message->title = $request->subject ?? '';
        $message->org_id = Auth::user()->org_id ?? '';
        $message->sent_by = Auth::user()->id ?? '';
        $message->message_type = $request->type ?? 1;
        $message->slug = Str::random(11);
        $message->content = $request->message;
        $message->sent_to = json_encode($this->getIntegerArray($request->to));
        $message->save();
        return $message;
    }

    public function saveTextMessage($subject, $text, $sentTo){
        $message = new Message();
        $message->title = $subject ?? '';
        $message->org_id = 1;
        $message->sent_by = Auth::user()->id ?? '';
        $message->message_type = 2; //text message
        $message->slug = Str::random(11);
        $message->content = $text;
        $message->sent_to = json_encode($this->getIntegerArray($sentTo));
        $message->save();
        return $message;
    }

    public function getIntegerArray($arr){
        $values = [];
        for($i = 0; $i<count($arr); $i++){
            array_push($values, (int) $arr[$i]);
        }
        return $values;
    }

    public function getReceivers($receivers){
        return Lead::whereIn('id', $receivers)->get();
    }
}
