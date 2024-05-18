<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChurchBranchLog extends Model
{
    use HasFactory;

    public function getUser(){
        return $this->belongsTo(User::class, 'cbl_user_id');
    }
}
