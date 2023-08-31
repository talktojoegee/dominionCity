<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;
    public static function registerActivity($orgId, $clientId, $userId, $leadId, $title, $log){
        //$ipAddress = $_SERVER['REMOTE_ADDR'];
        $orgId = Auth::user()->branch;
        $activity = new ActivityLog();
        $activity->org_id =  $orgId;// is now Branch ID;
        $activity->client_id = $clientId;
        $activity->user_id = $userId;
        $activity->lead_id = $leadId;
        $activity->title = $title;
        $activity->log = $log;
        //$activity->ip_address = $ipAddress;
        $activity->save();
    }
}
