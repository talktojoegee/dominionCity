<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashBookAccountLog extends Model
{
    use HasFactory;
    protected $primaryKey = 'cbal_id';




    public function addCashBookAccountLog($accountId, $userId, $branchId, $type, $narration){
        $log = new CashBookAccountLog();
        $log->cbal_cashbook_account_id = $accountId;
        $log->cbal_user_id = $userId;
        $log->cbal_branch_id = $branchId;
        $log->cbal_type = $type;
        $log->cbal_narration = $narration;
        $log->save();
    }

    public function getCashBookAccountLogs($accountId){
        return CashBookAccountLog::where('cbal_cashbook_account_id', $accountId)->orderBy('cbal_id', 'DESC')->get();
    }
}
