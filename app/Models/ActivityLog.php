<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    public static function registerActivity($orgId, $clientId, $userId, $leadId, $title, $log){
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $activity = new ActivityLog();
        $activity->org_id = $orgId;
        $activity->client_id = $clientId;
        $activity->user_id = $userId;
        $activity->lead_id = $leadId;
        $activity->title = $title;
        $activity->log = $log;
        $activity->ip_address = $ipAddress;
        $
        $activity->save();
    }
}
