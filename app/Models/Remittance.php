<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Remittance extends Model
{
    use HasFactory;

    public function getRemittedBy(){
        return $this->belongsTo(User::class, 'r_remitted_by');
    }

    public function getActedBy(){
        return $this->belongsTo(User::class, 'r_acted_by');
    }

    public function getCurrency(){
        return $this->belongsTo(Currency::class, 'r_currency_id');
    }

    public function getBranch(){
        return $this->belongsTo(ChurchBranch::class, 'r_branch_id');
    }

    public function getCategory(){
        return $this->belongsTo(TransactionCategory::class, 'r_category_id');
    }


    public function storeRemittance($branch,$amount, $rate, $paid, $refCode, $category,$type, $narration, $from, $to){
        $remit = new Remittance();
        $remit->r_branch_id = $branch;
        $remit->r_transaction_date = now();
        $remit->r_month = date('m');
        $remit->r_year = date('Y');
        $remit->r_amount =  round($amount * $rate/100,2); //amount remitted
        $remit->r_actual_amount = $amount; //actual amount
        $remit->r_rate = $rate;
        $remit->r_currency_id = $rate;
        $remit->r_paid = $paid;
        $remit->r_ref_code = $refCode;
        $remit->r_remitted_by = Auth::user()->id;
        $remit->r_category_id = $category;
        $remit->r_type = $type;
        $remit->r_narration = $narration;
        $remit->r_from = $from;
        $remit->r_to = $to;
        $remit->save();
        return $remit;
    }
    public function getDefaultCurrency(){
        $symbol = env('APP_CURRENCY');
        return Currency::where('symbol', $symbol)->first();
    }
    public function getRemittanceRecordByDateRange($from, $to, $branchId){
        $defaultCurrency = $this->getDefaultCurrency();
        return Remittance::whereBetween('r_transaction_date', [$from, $to])
            ->whereMonth('r_transaction_date', date('m'))
            ->whereYear('r_transaction_date', date('Y'))
            ->orderBy('r_id', 'ASC')
            ->get();
        //return CashBook::whereBetween('cashbook_transaction_date', [$from, $to])
           /* ->where('cashbook_branch_id', $branchId)
            //->where('cashbook_currency_id', $defaultCurrency->id)
            ->whereMonth('cashbook_transaction_date', date('m'))
            ->whereYear('cashbook_transaction_date', date('Y'))
            //->groupBy('cashbook_category_id')
            ->orderBy('cashbook_id', 'ASC')
            ->get();*/
    }


    public function getCashbookTransactions($remittanceRefNo){
        return CashBook::where('cashbook_remittance_ref_no', $remittanceRefNo)
            ->where('cashbook_credit', '>', 0)
            ->orderBy('cashbook_id', 'DESC')->get();
    }


}
