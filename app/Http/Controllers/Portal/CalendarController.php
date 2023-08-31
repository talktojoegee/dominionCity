<?php

namespace App\Http\Controllers\portal;

use App\Http\Controllers\Controller;
use App\Jobs\HandleNotifications;
use App\Models\AppointmentType;
use App\Models\Attendance;
use App\Models\Calendar;
use App\Models\CalendarComment;
use App\Models\CalendarInvitee;
use App\Models\Client;
use App\Models\ClientGroup;
use App\Models\Location;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    //$subject, $body, $route_name, $route_param, $route_type, $user_id, $org_id
    public $route_name;
    public $route_param;
    public $route_type;
    public $user_id;
    public $orgId;

    public function __construct(){
        $this->middleware('auth');
        $this->client = new Client();
        $this->appointmenttype = new AppointmentType();
        $this->calendar = new Calendar();
        $this->location = new Location();
        $this->calendarinvitee = new CalendarInvitee();
        $this->calendarcomment = new CalendarComment();
        $this->room = new Room();
        $this->clientgroup = new ClientGroup();

        $this->attendance = new Attendance();

    }

    public function showCalendar(){
        $events = array();
        $calendarEvents = $this->calendar->getCalendarEvents();
        foreach($calendarEvents as $eve){
            $events [] = [
              'title'=>$eve->note,
              'start'=>$eve->event_date,
              'end'=>$eve->end_date,
              'color'=>$eve->color,
              'id'=>$eve->id,
              'url'=>route('show-appointment-details', $eve->slug)
            ];
        }
        return view('calendar.index',[
            'clients'=>$this->client->getClientsByStatus(1),
            'appointmentTypes'=>$this->appointmenttype->getAppointmentTypes(),
            'events'=>$events,
            'locations'=>$this->location->getLocations(),
            'rooms'=>$this->room->getRooms(),
            'clientGroups'=>$this->clientgroup->getClientGroups()
        ]);
    }
    public function addCalendarEvent(Request $request){
        $this->validate($request,[
            //'note'=>'required',
            'when'=>'required|date',
            'invitee'=>'required',
            'appointmentType'=>'required',
            'sessionType'=>'required',
            'contactType'=>'required',
        ],[
            //'note.required'=>'Enter a note for this event',
            'when.required'=>'When is this even scheduled to take place?',
            'when.date'=>'Enter a valid date-time format.',
            'invitee.required'=>"Choose the invited client",
            'appointmentType.required'=>"What's the appointment type?",
            'contactType.required'=>"Select a contact type",
        ]);
        try{
            $event = $this->calendar->addCalendarEvent($request);
            $this->calendarinvitee->addInvitee($event->id, $request->invitee);
            //$subject, $body, $route_name, $route_param, $route_type, $user_id, $org_id
            $this->user_id = Auth::user()->id;
            $this->orgId = Auth::user()->org_id;
            $this->dispatchAnEvent($event, 'show-appointment-details', 1);
            session()->flash("success", "Your calendar event was published!");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Something went wrong. Try again later");
            return back();
        }

    }

    public function addGroupCalendarEvent(Request $request){
        $this->validate($request,[
            'note'=>'required',
            'when'=>'required|date',
            'invitees'=>'required',
            'appointmentType'=>'required',
            'contactType'=>'required',
            'maxAttendees'=>'required',
            'sessionType'=>'required',

        ],[
            'note.required'=>'Enter a note for this event',
            'when.required'=>'When is this even scheduled to take place?',
            'when.date'=>'Enter a valid date-time format.',
            'invitees.required'=>"Choose the invited client",
            'appointmentType.required'=>"What's the appointment type?",
            'contactType.required'=>"Select a contact type",
            'maxAttendees.required'=>"What's the maximum number of persons that can attend this session?",
        ]);
        try{
            $event = $this->calendar->addCalendarEvent($request);
            foreach($request->invitees as $invite){
                $this->calendarinvitee->addInvitee($event->id, $invite);
            }
            $this->user_id = Auth::user()->id;
            $this->orgId = Auth::user()->org_id;
            $this->dispatchAnEvent($event, 'show-appointment-details', 1);
            session()->flash("success", "Your Group session was published!");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Whoops! Something went wrong.");
            return back();
        }

    }
    public function addBlockCalendarEvent(Request $request){
        $this->validate($request,[
            'note'=>'required',
            'when'=>'required|date',
            'endDate'=>'required',
            'sessionType'=>'required',

        ],[
            'note.required'=>'Enter a note for this event',
            'when.required'=>'When is this scheduled to start?',
            'end_date.required'=>'When is this expected to end?'
        ]);
        try{
            $event = $this->calendar->addCalendarEvent($request);
            $this->user_id = Auth::user()->id;
            $this->orgId = Auth::user()->org_id;
            $this->dispatchAnEvent($event, 'show-appointment-details', 1);
            session()->flash("success", "Your Block session was published!");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Whoops! Something went wrong.");
            return back();
        }

    }

   public function showAppointments(){
        return view('calendar.appointments',[
        'appointments'=>$this->calendar->getUserAppointments(Auth::user()->id, Auth::user()->org_id),
        'yesterdays'=>$this->calendar->getUserYesterdaysAppointments(Auth::user()->id, Auth::user()->org_id),
        'todays'=>$this->calendar->getUserTodaysAppointments(Auth::user()->id, Auth::user()->org_id),
        'thisWeek'=>$this->calendar->getUserThisWeekAppointments(Auth::user()->id, Auth::user()->org_id),
        'clients'=>$this->client->getAllMyClients(Auth::user()->id, Auth::user()->org_id),
        'appointmentTypes'=>$this->appointmenttype->getAppointmentTypes()
        ]);
   }


   public function showAppointmentDetails($slug){
        $appointment = $this->calendar->getAppointmentBySlug($slug);
        if(!empty($appointment)){
            $inviteesIds = [];
            foreach($appointment->getInvitees as $invitee){
                array_push($inviteesIds, $invitee->invitee_id);
            }

            $otherAppointmentsIds = $this->calendarinvitee->pluckAppointmentIdsByInviteeId($inviteesIds);
            $otherAppointments = $this->calendar->getAppointmentArrayByIds($otherAppointmentsIds);
            $upcomingAppointmentsIds = [];
            $pastAppointmentsIds = [];
            foreach($otherAppointments as $other){
                if(strtotime($other->event_date) > strtotime(now())){
                    array_push($upcomingAppointmentsIds, $other->id);
                }else{
                    array_push($pastAppointmentsIds, $other->id);
                }
            }

            $upcomingAppointments = $this->calendar->getAppointmentArrayByIds($upcomingAppointmentsIds);
            $pastAppointments = $this->calendar->getAppointmentArrayByIds($pastAppointmentsIds);
            return view('calendar.appointment-details', [
                'appointment'=>$appointment,
                'upcomingAppointments'=>$upcomingAppointments,
                'pastAppointments'=>$pastAppointments,
            ]);
        }else{
            return back();
        }
   }

   public function leaveANote(Request $request){
        $this->validate($request,[
            "note"=>'required',
            "appointmentId"=>"required"
        ]);
        $this->calendarcomment->leaveANote($request);
        session()->flash("Your note is taken into account.");
        return back();
   }

   public function changeStatus(Request $request){
        $this->validate($request,[
            'status'=>'required',
            'calendarId'=>'required'
        ],[
            'status.required'=>'Select a status to update appointment'
        ]);
        $this->calendar->changeAppointmentStatus($request->calendarId, $request->status);
       session()->flash("You've successfully updated appointment status.");
       return back();
   }

   public function filterAppointment(Request $request){
        $this->validate($request,[
            "appointmentType"=>"required",
            "appointmentStatus"=>"required",
            "location"=>"required",
            "showAppointments"=>"required",
        ]);
   }

   public function dispatchAnEvent($event, $routeName, $routeType){
       //$subject, $body, $route_name, $route_param, $route_type, $user_id, $org_id
       $this->route_name = $routeName;
       $this->route_param = $event->slug;
       $this->route_type = $routeType;
       dispatch(new HandleNotifications($event->note, 'You have a new calendar event.',
           $this->route_name, $this->route_param, $this->route_type, $this->user_id, $this->orgId));
   }



   public function showAttendance(){
       $branchId = Auth::user()->branch;
        return view('attendance.index',[
            'attendance'=>$this->attendance->getBranchCurrentYearAttendance($branchId),
            'lastYear'=>$this->attendance->getBranchLastYearAttendance($branchId),
            'currentMonth'=>$this->attendance->getBranchCurrentMonthAttendance($branchId),
            'lastMonth'=>$this->attendance->getBranchLastMonthAttendance($branchId)
        ]);
   }

   public function publishAttendance(Request $request){
        $this->validate($request,[
            'programName'=>'required',
            'programDate'=>'required',
        ],[
            'programName.required'=>"Enter program name",
            'programDate.required'=>"Enter program date",
        ]);

        $this->attendance->registerAttendance($request);
        session()->flash("success", "Success! Attendance recorded.");
        return back();
   }
   public function updateAttendance(Request $request){
        $this->validate($request,[
            'programName'=>'required',
            'programDate'=>'required',
            'attendanceId'=>'required'
        ],[
            'programName.required'=>"Enter program name",
            'programDate.required'=>"Enter program date",
            'attendanceId.required'=>''
        ]);

        $this->attendance->editAttendance($request);
        session()->flash("success", "Success! Your changes were saved.");
        return back();
   }

    public function getAttendanceChart(){

        return response()->json([
            'men'=>$this->attendance->getThisYearAttendanceStat('a_no_men'),
            'women'=>$this->attendance->getThisYearAttendanceStat('a_no_women'),
            'children'=>$this->attendance->getThisYearAttendanceStat('a_no_children'),
        ],200);
    }

}
