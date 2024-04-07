<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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



}
