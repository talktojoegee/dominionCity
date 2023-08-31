<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Medication extends Model
{
    /*
     *
     * In this dispensation, Medication Model is used for follow-up or as Follow-up Model.
     * This should be noted.
     */
    use HasFactory;

   public function getPrescribedBy(){
       return $this->belongsTo(User::class, 'prescribed_by');
   }
   public function getClientMedicationReports(){
       return $this->hasMany(MedicationReport::class, 'medication_id')->orderBy('id', 'DESC');
   }

    public function addMedication(Request $request){
        $medication = new Medication();
        $medication->org_id = Auth::user()->org_id;
        $medication->added_by = Auth::user()->id;
        $medication->client_id = $request->clientId;
        $medication->prescribed_by = Auth::user()->id;
        $medication->drug_name = $request->drugName;
        $medication->prescription = $request->prescription;
        $medication->start_date = $request->startDate;
        $medication->end_date = now();
        $medication->quantity = 0;
        $medication->slug = Str::random(11);
        $medication->save();
        return $medication;
    }
    public function editMedication(Request $request){
        $medication = Medication::find($request->medicationId);
        $medication->org_id = Auth::user()->org_id;
        $medication->added_by = Auth::user()->id;
        $medication->client_id = $request->clientId;
        $medication->prescribed_by = Auth::user()->id;
        $medication->drug_name = $request->drugName;
        $medication->prescription = $request->prescription;
        $medication->start_date = $request->startDate;
        $medication->end_date = now();
        $medication->quantity =  0;
        //$medication->slug = Str::random(11);
        $medication->save();
        return $medication;
    }

    public function getOrgMedications(){
        return Medication::where('org_id', Auth::user()->org_id)->orderBy('id', 'DESC')->get();
    }
    public function getOrgMedicationBySlug($slug){
        return Medication::where('org_id', Auth::user()->org_id)->where('slug', $slug)->first();
    }

    public function getMedicationChart(){
        return Medication::select(
            DB::raw("DATE_FORMAT(start_date, '%m-%Y') monthYear"),
            DB::raw("YEAR(start_date) year, MONTH(start_date) month"),
            DB::raw("SUM(org_id) amount"),
            'start_date',
        )->whereYear('start_date', date('Y'))
            ->where('org_id', Auth::user()->org_id)
            ->orderBy('month', 'ASC')
            ->groupby('year','month')
            ->get();
    }
}
