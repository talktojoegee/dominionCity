<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model
{
    use HasFactory;

    public static function queueEmail($userId, $subject, $message){
        $mail = new EmailQueue();
        $mail->user_id = $userId;
        $mail->subject = $subject;
        $mail->message = $message;
        $mail->save();
    }


    public static function getPendingEmails(){
        return EmailQueue::where('status',0)->orderBy('id', 'DESC')->get();
    }


}
