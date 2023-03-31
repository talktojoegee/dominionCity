<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationshipType extends Model
{
    use HasFactory;

    protected $primaryKey = 'rt_id';
    protected $fillable = [
        'rt_name', 'rt_slug',
    ];
}
