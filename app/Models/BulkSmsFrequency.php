<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkSmsFrequency extends Model
{
    use HasFactory;
    protected $fillable = [
        'label',
        'value',
        'letter',
    ];

    public static function getBulkSmsFrequencies(){
        return BulkSmsFrequency::orderBy('id', 'ASC')->get();
    }

    public static function getBulkFrequencyById($id){
        return BulkSmsFrequency::find($id);
    }
}
