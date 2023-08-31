<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneGroup extends Model
{
    use HasFactory;

    public function setNewPhoneGroup(Request $request, $phone_numbers){
        $group = new PhoneGroup();
        $group->user_id = Auth::user()->id;
        $group->added_by = Auth::user()->id;
        $group->group_name = $request->group_name ?? '' ;
        $group->phone_numbers = $phone_numbers ?? '';
        $group->slug = substr(sha1(time()),27,40);
        $group->save();
    }

    public function updatePhoneGroup(Request $request, $phone_numbers){
        $group =  PhoneGroup::find($request->group);
        $group->user_id = Auth::user()->id;
        $group->added_by = Auth::user()->id;
        $group->group_name = $request->group_name ?? '' ;
        $group->phone_numbers = $phone_numbers ?? '';
        $group->slug = substr(sha1(time()),27,40);
        $group->save();
    }

    public function getAllUserPhoneGroups(){
        return PhoneGroup::where('user_id', Auth::user()->id)->orderBy('group_name', 'ASC')->get();
    }

    public function getPhoneGroupArrayById($ids){
        return PhoneGroup::whereIn('id', $ids)->get();
    }

    public function getNumberOfContacts($group_id){
        $group = PhoneGroup::find($group_id);
        $counter = explode(',', $group->phone_numbers);
        return count($counter);
    }
}
