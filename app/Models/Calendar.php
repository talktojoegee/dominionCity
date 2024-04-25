<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Calendar extends Model
{
    use HasFactory;
    public function getClient(){
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function getInvitees(){
        return $this->hasMany(CalendarInvitee::class, 'calendar_id');
    }
   /* public function getInvitedPerson(){
        return $this->belongsTo(CalendarInvitee::class, 'invitee_id');
    }*/

    public function getLocation(){
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function getRoom(){
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function getComments(){
        return $this->hasMany(CalendarComment::class, 'calendar_id')->orderBy('id', 'DESC');
    }


    public function getDocuments(){
        return $this->hasMany(FileModel::class, 'calendar_id')->orderBy('id', 'DESC');
    }



    public function getAppointmentType(){
        return $this->belongsTo(AppointmentType::class, 'appoint_type');
    }
    public function addCalendarEvent(Request $request){
        $event = new Calendar();
        $event->org_id = Auth::user()->org_id;
        $event->created_by = Auth::user()->id;
        $event->client_id = $request->invitee;
        $event->location_id = $request->location ?? null;
        $event->appoint_type = $request->appointmentType ?? null;
        $event->contact_type = $request->contactType ?? null;
        $event->room_id = $request->room ?? null;
        $event->max_attendees = $request->maxAttendees ?? 0;
        $event->note = $request->note ?? null;
        $event->event_date = $request->when ?? null;
        $event->end_date = $request->endDate ?? null;
        $event->session_type = $request->sessionType ?? null;
        $event->color = $this->generateRandomColorString();
        $event->slug = Str::random(11);
        $event->save();
        return $event;
    }

    public function generateRandomColorString(){
        return '#'.str_pad(dechex(mt_rand(0,0xFFFFFF)),6,'0', STR_PAD_LEFT);
    }

    public function thisMonthsEvents($orgId, $userId){
        return Calendar::where('org_id', $orgId)->where('created_by', $userId)->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get();
    }
    public function thisWeeksEvents($orgId, $userId){
        return Calendar::where('org_id', $orgId)->where('created_by', $userId)->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get();
    }

     public function yesterdayEvents($orgId, $userId){
        return Calendar::where('org_id', $orgId)->where('created_by', $userId)->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get();
    }



    public function calendarEvents(){
       return Calendar::select('note as title', 'event_date as start', 'color as color')
            ->get();
       // return response($reminder);
    }

    public function getClientById($id){
        return Client::find($id);
    }

    public function getCalendarEvents(){
        return Calendar::all();
    }

    public function getUserAppointments(){
        return Calendar::orderBy('id', 'DESC')->get();
    }

    public function getAllOrgsAppointments($orgId){
        return Calendar::where('org_id', $orgId)->orderBy('id', 'DESC')->get();
    }

     public function getAllPractitionerAppointments($orgId, $userId){
            return Calendar::where('org_id', $orgId)->where('created_by', $userId)->orderBy('id', 'DESC')->get();
        }
     public function getAllPractitionerAppointmentsByDateRange($userId, $from, $to){
            return Calendar::/*where('org_id', $orgId)->*/where('created_by', $userId)
                ->whereBetween('event_date', [$from, $to])
                ->orderBy('id', 'DESC')->get();
        }

    /* public function getUserAppointments($userId, $orgId){
    return Calendar::where('org_id', $orgId)->where('created_by', $userId)->orderBy('id', 'DESC')->get();

   }

    public function getUserYesterdaysAppointments($userId, $orgId){
        $yesterday = date("Y-m-d", strtotime( '-1 days' ) );
        return Calendar::where('org_id', $orgId)->where('created_by', $userId)->whereDate('event_date', $yesterday)->orderBy('id', 'DESC')->get();
    }

    public function getUserThisYearsAppointments($userId, $orgId){
        return Calendar::where('org_id', $orgId)->where('created_by', $userId)->whereYear('event_date', date('Y'))->orderBy('id', 'DESC')->get();
    }

    public function getUserTodaysAppointments($userId, $orgId){
        return Calendar::where('org_id', $orgId)->where('created_by', $userId)->whereDate('event_date', DB::raw('CURDATE()'))->orderBy('id', 'DESC')->get();
    }
    public function getUserThisWeekAppointments($userId, $orgId){
        return Calendar::where('org_id', $orgId)->where('created_by', $userId)->whereBetween('event_date', [Carbon::now()->startOfWeek(Carbon::SUNDAY), Carbon::now()->endOfWeek(Carbon::SATURDAY) ])->orderBy('id', 'DESC')->get();
    }*/
    public function getUserYesterdaysAppointments(){
        $yesterday = date("Y-m-d", strtotime( '-1 days' ) );
        return Calendar::whereDate('event_date', $yesterday)->orderBy('id', 'DESC')->get();
    }

    public function getUserThisYearsAppointments(){
        return Calendar::whereYear('event_date', date('Y'))->orderBy('id', 'DESC')->get();
    }

    public function getThisMonthsAppointments(){
        return Calendar::whereMonth('event_date', date('m'))
            ->whereYear('event_date', date('Y'))
            ->orderBy('event_date', 'DESC')->get();
    }

    public function getUserTodaysAppointments(){
        return Calendar::whereDate('event_date', DB::raw('CURDATE()'))->orderBy('id', 'DESC')->get();
    }
    public function getUserThisWeekAppointments(){
        return Calendar::whereBetween('event_date', [Carbon::now()->startOfWeek(Carbon::SUNDAY), Carbon::now()->endOfWeek(Carbon::SATURDAY) ])->orderBy('id', 'DESC')->get();
    }
     public function getUserAppointmentsByStatus($userId, $orgId, $status){
            return Calendar::where('org_id', $orgId)->where('created_by', $userId)->where('status', $status)->orderBy('id', 'DESC')->get();
        }

    public function getAppointmentBySlug($slug){
        return Calendar::where('slug', $slug)->first();
    }
    public function getAppointmentArrayByIds($ids){
        return Calendar::whereIn('id', $ids)->get();
    }

    public function getOrgAppointmentsByDateRange(Request $request)
    {
        return Calendar::where('org_id', Auth::user()->org_id)
            ->whereBetween('event_date', [$request->from, $request->to])->get();
    }

    public function changeAppointmentStatus($calendarId, $status){
        $calendar = Calendar::find($calendarId);
        $calendar->status = $status;
        $calendar->save();
    }

    public function getAttendanceChart(){
        return Calendar::select(
            DB::raw("DATE_FORMAT(event_date, '%m-%Y') monthYear"),
            DB::raw("YEAR(event_date) year, MONTH(event_date) month"),
            DB::raw("SUM(org_id) amount"),
            'event_date',
        )->whereYear('event_date', date('Y'))
            ->where('org_id', Auth::user()->org_id)
            ->orderBy('month', 'ASC')
            ->groupby('year','month')
            ->get();
    }
}
