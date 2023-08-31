<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
