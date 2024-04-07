<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CashBookAccount extends Model
{
    use HasFactory;
    protected $primaryKey = 'cba_id';

    public function getCashbookCreatedBy(){
        return $this->belongsTo(User::class, 'cba_created_by');
    }
    public function getCurrency(){
        return $this->belongsTo(Currency::class, 'cba_currency');
    }



    public function checkForExistingAccount($name, $branchId, $type){
        return CashBookAccount::where('cba_name', $name)->where('cba_branch_id', $branchId)->where('cba_type', $type)->first();
    }

    public function addCashBookAccount($type, $scope, $name, $account_no, $amount, $note = 'New Cashbook account created', $currency){
        $cashbook = new CashBookAccount();
        $cashbook->cba_branch_id = Auth::user()->branch;
        $cashbook->cba_created_by = Auth::user()->id;
        $cashbook->cba_date_created = now();
        $cashbook->cba_scope = $scope;
        $cashbook->cba_type = $type;
        $cashbook->cba_name = $name;
        $cashbook->cba_currency = $currency;
        $cashbook->cba_amount = $amount;
        $cashbook->cba_account_no = $account_no;
        $cashbook->cba_note = $note;
        $cashbook->save();
        return $cashbook;
    }




    public function editCashBookAccount($id,  $author, $type, $name, $amount, $note = 'Changes to cashbook account effected!'){
        $cashbook =  CashBookAccount::find($id);
        $cashbook->cba_created_by = $author;
        $cashbook->cba_date_created = now();
        $cashbook->cba_type = $type;
        $cashbook->cba_name = $name;
        $cashbook->cba_amount = $amount;
        $cashbook->cba_note = $note;
        $cashbook->save();
        return $cashbook;
    }




    public function getBranchAccounts($branchId){
        return CashBookAccount::where('cba_branch_id', $branchId)->orderBy('cba_name', 'ASC')->get();
    }



    public function getBranchFirstAccount($branchId){
        return CashBookAccount::where('cba_branch_id', $branchId)->first();
    }


    public function getAllCashbookAccounts(){
        return CashBookAccount::orderBy('cba_name', 'ASC')->get();
    }

    public function generateVirtualAccountNo(){
        return time();
    }


    public function getAccountCashbookRecords($accountId){
        return CashBook::where('cashbook_account_id', $accountId)->get();
    }

}
