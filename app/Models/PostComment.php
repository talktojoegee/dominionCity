<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;
    protected $primaryKey = 'pc_id';


    public function getUser(){
        return $this->belongsTo(User::class, 'pc_user_id');
    }

    public static function leaveComment($postId, $author, $message){
        $comment = new PostComment();
        $comment->pc_post_id = $postId;
        $comment->pc_user_id = $author;
        $comment->pc_comment = $message;
        $comment->save();
    }

    public static function getCommentsByPostId($postId){
        return PostComment::where('pc_post_id', $postId)->orderBy('pc_id', 'DESC')->get();
    }
}
