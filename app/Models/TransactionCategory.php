<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TransactionCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'tc_id';


    public function getCreatedBy(){
        return $this->belongsTo(User::class, 'tc_created_by');
    }

    public function getBranch(){
        return $this->belongsTo(ChurchBranch::class, 'tc_branch_id');
    }
    public function addTransactionCategory($name, $type, $remittance, $rate){
        $cat = new TransactionCategory();
        $cat->tc_name = $name;
        $cat->tc_type = $type;
        $cat->tc_branch_id = Auth::user()->branch;
        $cat->tc_created_by = Auth::user()->id;
        $cat->tc_remittable = $remittance ?? 0;
        $cat->tc_proposed_rate = $rate ?? 0 ;
        $cat->save();
        return $cat;
    }


    public function editTransactionCategory($id, $name, $type, $status, $remittance, $rate){
        $cat = TransactionCategory::find($id);
        $cat->tc_name = $name;
        $cat->tc_type = $type;
        $cat->tc_status = $status;
        $cat->tc_remittable = $remittance ?? 0;
        $cat->tc_proposed_rate = $rate ?? 0 ;
        $cat->save();
        return $cat;
    }

    public function getAllIncomeCategories(){
        return TransactionCategory::where('tc_type', 1)->orderBy('tc_name', 'ASC')->get();
    }

     public function getAllExpenseCategories(){
        return TransactionCategory::where('tc_type', 2)->orderBy('tc_name', 'ASC')->get();
    }


    public function getBranchCategories($branchId){
        return TransactionCategory::where('tc_branch_id', $branchId)->orderBy('tc_name', 'ASC')->get();
    }


    public function getBranchCategoriesByType($branchId, $type){
        return TransactionCategory::where('tc_branch_id', $branchId)
            ->where('tc_type', $type)->orderBy('tc_name', 'ASC')->get();
    }

    public static function getOneBranchCategoryByType($name, $branchId, $type){
        return TransactionCategory::where('tc_branch_id', $branchId)
            ->where('tc_type', $type)->where('tc_name', $name)->first();
    }


    public function checkNameExistForBranch($name, $branchId, $type){
        return TransactionCategory::where('tc_name', $name)->where('tc_branch_id', $branchId)->where('tc_type', $type)->first();
    }


}
