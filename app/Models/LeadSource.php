<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadSource extends Model
{
    use HasFactory;
    protected $fillable = [
        'source'
    ];


    public function getLeadSources(){
        return LeadSource::all();
    }
}
