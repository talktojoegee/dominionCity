<?php

namespace App\Http\Controllers\portal;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Medication;
use App\Models\MedicationReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->medication = new Medication();
        $this->medicationreport = new MedicationReport();
        $this->client = new Client();
    }

    public function addMedication(Request $request){
        $this->validate($request,[
           "drugName"=>"required",
           "startDate"=>"required|date",
           //"endDate"=>"required|required",
            "clientId"=>"required",
            "prescription"=>"required"
        ],[
            "drugName.required"=>"What's the subject of your discussion?",
            "startDate.required"=>"When did this conversation or follow-up take place?",
            //"endDate.required"=>"Alright, when is the medication expected to end?",
            "startDate.date"=>"Enter a valid date format",
            //"endDate.date"=>"Enter a valid date format",
            "prescription.required"=>"Enter details in the box provided."
        ]);
        $this->medication->addMedication($request);
        $log = Auth::user()->first_name.' '.Auth::user()->last_name.' recently followed up';
        ActivityLog::registerActivity(Auth::user()->org_id, $request->clientId, Auth::user()->id, null, 'New follow-up', $log);
        session()->flash("success", "Action successful!");
        return back();
    }
    public function editMedication(Request $request){
        $this->validate($request,[
           "drugName"=>"required",
           "startDate"=>"required|date",
           //"endDate"=>"required|required",
            "medicationId"=>"required",
            "prescription"=>"required"
        ],[
            "drugName.required"=>"What's the subject of your discussion?",
            "startDate.required"=>"When did this conversation or follow-up take place?",
            //"endDate.required"=>"Alright, when is the medication expected to end?",
            "startDate.date"=>"Enter a valid date format",
            //"endDate.date"=>"Enter a valid date format",
            "prescription.required"=>"Enter details in the box provided."
        ]);
        $this->medication->editMedication($request);
        $log = Auth::user()->first_name.' '.Auth::user()->last_name.' made some changes to user follow-up';
        ActivityLog::registerActivity(Auth::user()->org_id, $request->clientId, Auth::user()->id, null, 'Changes to follow-up', $log);
        session()->flash("success", "Success! Your changes were saved.");
        return back();
    }

    public function showMedicationDetails(Request $request){
        $medication = $this->medication->getOrgMedicationBySlug($request->slug);
        if(!empty($medication)){
            return view('medication.show',[
                'medication'=>$medication,
                'client'=>$this->client->getClientById($medication->client_id)
            ]);
        }
    }

    public function submitMedicationReport(Request $request){
        $this->validate($request,[
            "report"=>"required",
            "medicationId"=>"required"
        ],[
            "report.required"=>"Type your report here before submitting..."
        ]);
        $this->medicationreport->addMedicationReport($request);
        session()->flash("success", "Success! Report submitted.");
        return back();
    }
}
