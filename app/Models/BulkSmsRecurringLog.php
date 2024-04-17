<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkSmsRecurringLog extends Model
{
    use HasFactory;


    public static function newSmsLog($masterId, $message, $to, $batchCode){
        $log = new BulkSmsRecurringLog();
        $log->master_id = $masterId;
        $log->message = $message;
        $log->sent_to = $to;
        $log->batch_code = $batchCode;
        $log->save();
    }
}
