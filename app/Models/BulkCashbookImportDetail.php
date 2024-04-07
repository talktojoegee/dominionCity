<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkCashbookImportDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'bcid_id';
    protected $fillable = [
        'created_at',
        'bcid_transaction_date',
        'bcid_description',
        'bcid_narration',
        'bcid_category_id',
        'bcid_debit',
        'bcid_credit',
        'bcid_transaction_type',
        'bcid_branch_id',
        'bcid_account_id',
        'bcid_user_id',
        'bcid_master_id',
        'bcid_month',
        'bcid_year',
        'bcid_ref_code',
    ];

    public function getCategory(){
        return $this->belongsTo(TransactionCategory::class, "bcid_category_id");
    }

    public function getRecordById($id){
        return BulkCashbookImportDetail::find($id);
    }

    public function getRecordByBatchCode($batchCode){
        return BulkCashbookImportDetail::where("bcid_ref_code", $batchCode)->get();
    }
}
