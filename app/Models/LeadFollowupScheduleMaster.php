<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LeadFollowupScheduleMaster extends Model
{
    use HasFactory;

    public function getScheduledBy(){
        return $this->belongsTo(User::class, 'scheduled_by');
    }

    public function getLeadScheduleDetails(){
        return $this->hasMany(LeadFollowupScheduleDetail::class, 'master_id');
    }


    public function addScheduleMaster($date, $title, $objective, $periodMonth, $periodYear){
        $schedule = new LeadFollowupScheduleMaster();
        $schedule->scheduled_by = Auth::user()->id;
        $schedule->entry_date = $date;
        $schedule->period_month = $periodMonth;
        $schedule->period_year = $periodYear;
        $schedule->title = $title ?? null;
        $schedule->objective = $objective ?? null;
        $schedule->ref_code = substr(sha1(time()),21,40);
        $schedule->save();
        return $schedule;
    }

    public function getAllCurrentYearFollowupSchedules(){
        $currentYear = date('Y');
        return LeadFollowupScheduleMaster::whereYear('entry_date', $currentYear)->orderBy('id', 'DESC')->get();
    }

    public function getFollowupScheduleByRefCode($refCode){
        return LeadFollowupScheduleMaster::where('ref_code', $refCode)->first();
    }

    public function getLeadFollowupScheduleById($id){
        return LeadFollowupScheduleMaster::find($id);
    }

    public function getLeadFollowupMasterIdsByDateRange($startDate, $endDate){
        return LeadFollowupScheduleMaster::whereBetween('entry_date', [$startDate, $endDate])->pluck('id')->toArray();
    }


}
