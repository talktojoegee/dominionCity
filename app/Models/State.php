<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;


    public function getStatesByCountryId($countryId){
        return State::where('country_id', $countryId)->orderBy('name', 'ASC')->get();
    }

   /* public function getAllStates(){
        return State::orderBy('')->get();
    }*/
}
