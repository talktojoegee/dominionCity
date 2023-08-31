<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\CashBook;
use App\Models\CashBookAccount;
use App\Models\CashBookAccountLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashbookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->cashbookaccount = new CashBookAccount();
        $this->cashbook = new CashBook();
        $this->cashbooklog = new CashBookAccountLog();
    }




    public function showManageAccounts(){
        return view('accounting.accounts',[
            'accounts'=>$this->cashbookaccount->getBranchAccounts(Auth::user()->branch),
        ]);
    }

    public function addCashBook(Request $request){
        //return dd($request->all());
        $request->validate([
            "name"=>"required",
            "type"=>"required",
            "scope"=>"required",
        ],[
            'name.required'=>'Enter a name for this category',
            'type.required'=>'What will this account be used to track? Income or expense?',
            'scope.required'=>'What is the scope of this account? Branch, regional or global?',
        ]);
        if($request->type == 1){
            if(empty($request->accountNo)){
                session()->flash("error", "Whoops! Enter account number. This is required for a normal account.");
                return back();
            }
        }
        try{
            $validation = $this->cashbookaccount
                ->checkForExistingAccount($request->name, Auth::user()->branch, $request->type);
            if(!empty($validation)){
                session()->flash("error", "Whoops! There's already an account with the name you entered.");
                return back();
            }
            $accountNo = $request->type == 1 ? $request->accountNo : $this->cashbookaccount->generateVirtualAccountNo();
            $account = $this->cashbookaccount
                ->addCashBookAccount($request->type, $request->scope, $request->name, $accountNo, $request->amount ?? 0, $request->note);
            $amount = $request->openingBalance;
            if($amount > 0){
                //push to cashbook

            }
            session()->flash("success", "Action successful!");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Whoops! Something went wrong.");
            return back();
        }

    }
    public function editCashBook(Request $request){
        $request->validate([
            "name"=>"required",
            "type"=>"required",
            "status"=>"required",
            "catId"=>'required'

        ],[
            'name.required'=>'Enter a name for this category',
            'type.required'=>'What will this account be used to track? Income or expense?',
            'status.required'=>'Active or inactive?',
        ]);
        try{
            $validation = $this->transactioncategory
                ->checkNameExistForBranch($request->name, Auth::user()->branch, $request->type);
            if(!empty($validation)){
                if(($validation->tc_status != $request->status) || ($validation->tc_type != $request->type) ){
                    $this->transactioncategory->editTransactionCategory($request->catId, $request->name, $request->type, $request->status);
                    session()->flash("success", "Action successful. Your changes were saved!");
                    return back();
                }else{
                    session()->flash("error", "Whoops! There's already category with the name you entered.");
                    return back();
                }
            }
            $this->transactioncategory->editTransactionCategory($request->catId, $request->name, $request->type, $request->status);
            session()->flash("success", "Action successful. Your changes were saved!");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Whoops! Something went wrong.");
            return back();
        }

    }
}
