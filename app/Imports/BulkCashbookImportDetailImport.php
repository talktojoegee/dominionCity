<?php

namespace App\Imports;

use App\Models\BulkCashbookImportDetail;
use App\Models\CashBookAccount;
use App\Models\TransactionCategory;
use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BulkCashbookImportDetailImport implements ToModel, WithStartRow, WithMultipleSheets
{
    public $header, $branchId,$userId,$masterId,$accountId,$month,$year,$batchCode;

    /**
     * @return int
     */
    public function startRow(): int
    {
        if(isset($this->header)){
            return 2;
        }
        return 1;

    }
    public function sheets(): array
    {
        return [
            0 => $this,
            //1 => new SecondSheetImport(),
        ];
    }

    public function __construct($header, $branchId,$userId,$masterId,$accountId,$month,$year,$batchCode)
    {
        $this->branchId = $branchId;
        $this->userId = $userId;
        $this->masterId = $masterId;
        $this->accountId = $accountId;
        $this->month = $month;
        $this->year = $year;
        $this->batchCode = $batchCode;
        $this->header = $header;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {


        $debit = !empty($row[3]) ?  floatval(preg_replace('/[^\d.]/', '', $row[3])) : 0;
        $transactionType = 1; //income
        if($debit > 0){
            $transactionType = 2; //debit
        }
        $category = TransactionCategory::getOneBranchCategoryByType($row[2], $this->branchId, $transactionType);
        return new BulkCashbookImportDetail([
            'created_at'=> now(),
            'bcid_transaction_date'=> str_replace("/", "-", $row[0]),
            'bcid_description'=>$row[1],
            'bcid_narration'=>$row[1],
            'bcid_category_id'=> $category->tc_id ??  1,
            'bcid_debit'=> !empty($row[3]) ? floatval(preg_replace('/[^\d.]/', '', $row[3])) : 0,
            'bcid_credit'=> !empty($row[4]) ? floatval(preg_replace('/[^\d.]/', '', $row[4])) : 0,
            'bcid_transaction_type'=>$transactionType,
            'bcid_branch_id'=>$this->branchId,
            'bcid_account_id'=>$this->accountId,
            'bcid_user_id'=>$this->userId,
            'bcid_master_id'=>$this->masterId,
            'bcid_month'=>$this->month,
            'bcid_year'=>$this->year,
            'bcid_ref_code'=>$this->batchCode,
        ]);
    }
}
