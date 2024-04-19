<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeadFollowupScheduleDetail extends Model
{
    use HasFactory;

    public function getLead(){
        return $this->belongsTo(Lead::class, 'lead_id');
    }


    public function addDetail($masterId, $leadId){
        $detail = new LeadFollowupScheduleDetail();
        $detail->master_id = $masterId;
        $detail->lead_id = $leadId;
        $detail->save();
    }


    public function getTotalLeadFollowupDetailsByIds($ids){
        return LeadFollowupScheduleDetail::select(
            DB::raw("DATE_FORMAT(created_at, '%m-%Y') monthYear"),
            DB::raw("YEAR(created_at) year, MONTH(created_at) month"),
            DB::raw("COUNT(id) total"),
            'created_at',
        )->whereIn('master_id', $ids)
            ->orderBy('month', 'ASC')
            ->groupby('year','month')
            ->get();
    }



}
