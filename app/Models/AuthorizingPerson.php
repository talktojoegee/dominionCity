<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorizingPerson extends Model
{
    use HasFactory;

    protected $primaryKey = 'ap_id';

    public function getUser(){
        return $this->belongsTo(User::class, 'ap_user_id', 'id');
    }

    public static function publishAuthorizingPerson($postId, $userId){
        $auth = new AuthorizingPerson();
        $auth->ap_post_id = $postId;
        $auth->ap_user_id = $userId;
        $auth->save();
    }

    public static function updateStatus($postId,$authId, $userId, $status, $comment, $final = 0){
        $update = AuthorizingPerson::where('ap_post_id', $postId)
            ->where('ap_id', $authId)->where('ap_user_id', $userId)->first();
        $update->ap_status = $status;
        $update->ap_final = $final;
        $update->ap_comment = $comment ?? null;
        $update->save();
    }

    public static function pluckPendingAuthorizingPersonsByPostId($postId){
        return AuthorizingPerson::where('ap_status',0)->where('ap_post_id', $postId)->pluck('ap_user_id')->toArray();
    }
}
