<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BulkSmsAccount extends Model
{
    use HasFactory;



    public function creditAccount($ref, $amount, $cost, $user){
        $actual_amount = $cost; //$amount/100;
        $units = $cost/3;
        $trans = new BulkSmsAccount();
        $trans->ref_no = $ref;
        $trans->user_id = $user;
        $trans->credit = $actual_amount;
        $trans->no_units = $units;
        $trans->charge = ($amount/100) - $cost;
        $trans->unit_credit = $units;
        $trans->narration = "Purchase of ₦".number_format($actual_amount,2)." was successful.";
        $trans->save();
    }

    public function debitAccount($ref, $amount, $units){
        //$actual_amount = $amount;
        //$units = $cost/3;
        $trans = new BulkSmsAccount();
        $trans->ref_no = $ref;
        $trans->user_id = Auth::user()->id;
        $trans->debit = $amount;
        $trans->no_units = $units;
        $trans->unit_debit = $units;
        $trans->narration = "SMS sent @ ₦".$amount;
        $trans->save();
    }

    public function getBulkSmsTransactions(){
        return BulkSmsAccount::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
    }
}
