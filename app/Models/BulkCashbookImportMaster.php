<?php

namespace App\Models;

use App\Imports\BulkCashbookImportDetailImport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class BulkCashbookImportMaster extends Model
{
    use HasFactory;
    protected $primaryKey = 'bcim_id';

    public function getAccount(){
        return $this->belongsTo(CashBookAccount::class, "bcim_cba_id");
    }
    public function getImportedBy(){
        return $this->belongsTo(User::class, "bcim_imported_by");
    }

    public function getBulkImportDetails(){
        return $this->hasMany(BulkCashbookImportDetail::class, "bcid_master_id");
    }


    public function publishBulkImport(Request $request, $userId){

        $date = new \DateTime($request->monthYear);
        $bulk = new BulkCashbookImportMaster();
        $bulk->bcim_imported_by = $userId;
        $bulk->bcim_cba_id = $request->account ?? '';
        $bulk->bcim_batch_code = $request->batchCode ?? '' ;
        $bulk->bcim_month = $date->format('m');
        $bulk->bcim_year = $date->format('Y');
        $bulk->bcim_narration = $request->narration ?? '';
        $bulk->bcim_attachment =  $this->uploadFile($request) ?? '';
        $bulk->bcim_status = 0;
        $bulk->save();
        return $bulk;

    }

    public function getAllBulkImport(){
     return BulkCashbookImportMaster::orderBy("bcim_id", "DESC")->get();
    }

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('attachment')) {
            //return dd('yes');
                $file = $request->attachment;
                $extension = $file->getClientOriginalExtension();
                $filename = uniqid() . '_' . time() . '_' . date('Ymd') . '.' . $extension;
                $dir = 'assets/drive/import/';
                $file->move(public_path($dir), $filename);
                return $filename;

        }

    }

    public function getOneBulkImportByBatchCode($batchCode){
        return BulkCashbookImportMaster::where("bcim_batch_code", $batchCode)->first();
    }


}
