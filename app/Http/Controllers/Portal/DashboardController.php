<?php

namespace App\Http\Controllers\portal;

use App\Http\Controllers\Controller;
use App\Models\AppointmentType;
use App\Models\Calendar;
use App\Models\Client;
use App\Models\Medication;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Analytics;
use Spatie\Analytics\Period;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->product = new Product();
        $this->client = new Client();
        $this->sale = new Sale();
        $this->calendar = new Calendar();
        $this->medication = new Medication();
        $this->user = new User();
        $this->appointmenttype = new AppointmentType();
        $this->task = new Task();
    }

    public function showDashboard(Request $request):View{
        $orgId = Auth::user()->org_id;
        $userId = Auth::user()->id;
        //$ipAddress = $_SERVER['HTTP_USER_AGENT'];
        //$ipAddress = $_SERVER['REMOTE_ADDR'];
        //return dd($request->getClientIp());
        //retrieve visitors and pageview data for the current day and the last seven days
        //$data = Analytics::fetchMostVisitedPages(Period::years(7));
       // return dd($data);
        return view('dashboard',[
            'products'=>$this->product->getAllOrgProducts(),
            'clients'=>$this->client->getAllOrgClients($orgId),
            'sales'=>$this->sale->getOrgMonthsSales($orgId),
            'practitioners'=>$this->user->getAllOrgUsersByType(2),
            'thisWeek'=>$this->sale->getOrgThisWeekSales($orgId),
            'appointments'=>$this->calendar->getUserAppointments(Auth::user()->id, Auth::user()->org_id),
            'appointmentTypes'=>$this->appointmenttype->getAppointmentTypes(),
            'today'=>$this->calendar->getUserTodaysAppointments($userId, $orgId),
            'week'=>$this->calendar->getUserThisWeekAppointments($userId, $orgId),
            'unconfirmed'=>$this->calendar->getUserAppointmentsByStatus($userId, $orgId, 3),
            'tasks'=>$this->task->getOrgTasks($orgId)
        ]);
    }

    public function getAttendanceMedicationChart(){
        $attendance = $this->calendar->getAttendanceChart();
        $medication = $this->medication->getMedicationChart();
        return response()->json(['attendance'=>$attendance, 'medication'=>$medication],200);
    }
}
