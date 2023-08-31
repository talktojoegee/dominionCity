<?php

namespace App\Http\Controllers;
use App\Models\BulkSmsAccount;
use App\Models\CashBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yabacon\Paystack;


class OnlinePaymentController extends Controller
{


    public function __construct()
    {
        $this->bulksmsaccount = new BulkSmsAccount();

        $this->cashbook = new CashBook();
    }

    public function initializePaystack(){

    }
    public function processOnlinePayment(Request $request){
       // return dd('hello');
        /*
         * Transaction Type (Transaction):
         *  1 = New tenant subscription
         *  2 = Subscription Renewal
         *  3 = Invoice Payment
         *  4 = SMS Top-up
         */
        $reference = isset($request->reference) ? $request->reference : '';
        if(!$reference){
            die('No reference supplied');
        }
        $paystack = new Paystack(config('app.paystack_secret_key'));
        try {
            // verify using the library
            $tranx = $paystack->transaction->verify([
                'reference'=>$reference, // unique to transactions
            ]);
        }catch (Paystack\Exception\ApiException $exception){
            session()->flash("error", "Whoops! Something went wrong.");
            return redirect()->route('top-up');
        }
        if ('success' === $tranx->data->status) {
            try {
                //return dd($tranx->data->metadata->cost);
                $transaction_type = $tranx->data->metadata->transaction ;
                $account = $tranx->data->metadata->account ;
                $category = $tranx->data->metadata->category ;
                switch ($transaction_type){
                    case 4:
                        $branchId = Auth::user()->branch;
                        $defaultCurrency = env('NAIRA_ID');
                        $note = "Purchase of bulk SMS units. The amount includes convenience fee";
                        $this->bulksmsaccount->creditAccount($reference,
                            $tranx->data->amount, //50900
                            $tranx->data->metadata->cost, $tranx->data->metadata->user); //cost = 500
                        $this->cashbook->addCashBook($branchId, $category, $account,
                            $defaultCurrency, 2, 0, 2, now(),
                            $note, $note,
                            ($tranx->data->amount + $tranx->data->metadata->cost)/100,  0, substr(sha1(time()),31,40));
                        break;
                }
                switch ($transaction_type){
                    case 4:
                        session()->flash("success", "Your top-up transaction was successful.");
                        return redirect()->route('top-up');
                }
            }catch (Paystack\Exception\ApiException $ex){

            }

        }
    }


}
