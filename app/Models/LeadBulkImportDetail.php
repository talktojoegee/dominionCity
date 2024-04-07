<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadBulkImportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'master_id',
        'entry_date',
        'first_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'source_id',
        'gender',
        'address',
        'slug',
    ];

    public function getLeadDetailById($id){
        return LeadBulkImportDetail::find($id);
    }
    public function getLeadDetailByMasterId($masterId){
        return LeadBulkImportDetail::where('master_id',$masterId)->get();
    }
}
