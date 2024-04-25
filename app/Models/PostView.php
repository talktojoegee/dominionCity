<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    use HasFactory;

    public static function registerPostView($userId,$postId){
        $view = new PostView();
        $view->pv_user_id = $userId;
        $view->pv_post_id = $postId;
        $view->save();
    }


    public static function getPostViewByUserPostId($userId, $postId){
        return PostView::where('pv_post_id', $postId)->where('pv_user_id', $userId)->first();
    }

    public static function getPostViewsByPostId($postId){
        return PostView::where('pv_post_id',$postId)->count();
    }
}
