<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BulkMessage extends Model
{
    use HasFactory;

    public function getSender(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function getFrequency(){
        return $this->belongsTo(BulkSmsFrequency::class,'bulk_frequency');
    }

    public function getPhoneGroup(){
        return $this->belongsTo(PhoneGroup::class,'phone_group');
    }


    public function getUserAccount(){
        return $this->hasMany(BulkSmsAccount::class, 'user_id')->orderBy('id', 'DESC');
    }



    public function setNewMessage($msg, $phone_numbers, $senderId, $status, $startDate,
                                  $endDate, $frequency, $recurring, $phoneGroup){
        $batchCode = Str::random(11);
        $message = new BulkMessage();
        $message->user_id = Auth::user()->id;
        $message->sent_by = Auth::user()->id;
        $message->sender_id = $senderId;
        $message->status = $status;
        $message->slug = substr(sha1(time()),23,40);
        $message->message = $msg;
        $message->sent_to = $phone_numbers;
        $message->batch_code = $batchCode;
        $message->bulk_frequency = $frequency;
        $message->recurring_active = 1;
        $message->recurring = $recurring;
        $message->next_schedule = $endDate;
        $message->start_date = $startDate;
        $message->phone_group = $phoneGroup ?? null;
        $message->save();
    }

    public function getTenantMessages(){
        return BulkMessage::where('tenant_id', Auth::user()->tenant_id)->orderBy('id', 'DESC')->get();
    }

    public function getBranchMessages(){
        return BulkMessage::where('branch_id', Auth::user()->branch)->orderBy('id', 'DESC')->get();
    }
    public function getAllMessages(){
        return BulkMessage::orderBy('id', 'DESC')->get();
    }

    public function getTenantMessageBySlug($slug){
        return BulkMessage::where('tenant_id', Auth::user()->tenant_id)->where('slug', $slug)->first();
    }

    public function getMessageById($id){
        return BulkMessage::find($id);
    }

    public static function getRecurringMessages(){

        return BulkMessage::/*where("recurring", 1)*/where("recurring_active",1)->orderBy('id', 'DESC')->get();
    }

    public function getTotalSMSSentByDateRange($startDate, $endDate){
        return BulkMessage::select(
            DB::raw("DATE_FORMAT(next_schedule, '%m-%Y') monthYear"),
            DB::raw("YEAR(next_schedule) year, MONTH(next_schedule) month"),
            DB::raw("LENGTH(sent_to) - LENGTH(REPLACE(sent_to, ',', '')) + 1 total"),
            'next_schedule',
            //- CHAR_LENGTH(REPLACE(sent_to, ',', '')) + 1
        )->whereBetween('next_schedule', [$startDate, $endDate])
            //->where('a_branch_id', Auth::user()->branch)
            ->orderBy('month', 'ASC')
            ->groupby('year','month')
            ->get();
    }
}
