<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostCorrespondingPerson extends Model
{
    use HasFactory;

    protected $primaryKey = 'pcp_id';

    public static function storeDetails($postId, $type, $values){
        $corr = new PostCorrespondingPerson();
        $corr->pcp_post_id = $postId;
        $corr->pcp_type = $type;
        $corr->pcp_target = $values;
        $corr->save();
    }

    public function getCorrespondingPostsForEveryOne(){
        return PostCorrespondingPerson::pluck('pcp_post_id')->get();
    }
    public function getCorrespondingPosts($type, $targetId){
        return PostCorrespondingPerson::where('pcp_type', $type)
            ->whereJsonContains('pcp_target', $targetId)->get();
    }
}
