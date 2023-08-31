<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SenderId extends Model
{
    use HasFactory;


    public function createSenderId(Request $request){
        $sender = new SenderId();
        $sender->sender_id = $request->sender_id;
        $sender->purpose = $request->purpose;
        $sender->user_id = Auth::user()->id;
        $sender->save();
    }
    public function updateSenderId(Request $request){
        $sender =  SenderId::find($request->sender);
        $sender->sender_id = $request->sender_id;
        $sender->purpose = $request->purpose;
        $sender->user_id = Auth::user()->id;
        $sender->save();
    }

}
