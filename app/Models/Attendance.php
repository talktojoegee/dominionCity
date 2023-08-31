<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Attendance extends Model
{
    use HasFactory;
    protected $primaryKey = 'a_id';

    public function getTakenBy(){
        return $this->belongsTo(User::class, 'a_taken_by');
    }

    public function getBranch(){
        return $this->belongsTo(ChurchBranch::class, 'a_branch_id');
    }

    public function registerAttendance(Request $request){
        $branchId = Auth::user()->branch;
        $attendance = new Attendance();
        $attendance->a_taken_by = Auth::user()->id;
        $attendance->a_branch_id = $branchId;
        $attendance->a_program_name = $request->programName ?? null;
        $attendance->a_program_date = $request->programDate ?? null;
        $attendance->a_no_men = $request->men ?? null;
        $attendance->a_no_women = $request->women ?? null;
        $attendance->a_no_children = $request->children ?? null;
        $attendance->a_total = ($request->men ?? 0 + $request->women ?? 0 + $request->children ?? 0);
        $attendance->a_narration = $request->narration ?? null;
        $attendance->save();
        return $attendance;
    }


    public function editAttendance(Request $request){
        $branchId = Auth::user()->branch;
        $attendance =  Attendance::find($request->attendanceId);
        $attendance->a_taken_by = Auth::user()->id;
        $attendance->a_branch_id = $branchId;
        $attendance->a_program_name = $request->programName ?? null;
        $attendance->a_program_date = $request->programDate ?? null;
        $attendance->a_no_men = $request->men ?? null;
        $attendance->a_no_women = $request->women ?? null;
        $attendance->a_no_children = $request->children ?? null;
        $attendance->a_total = ($request->men ?? 0 + $request->women ?? 0 + $request->children ?? 0);
        $attendance->a_narration = $request->narration ?? null;
        $attendance->save();
        return $attendance;
    }

    public function getThisYearAttendanceStat($type){
        return Attendance::select(
            DB::raw("DATE_FORMAT(a_program_date, '%m-%Y') monthYear"),
            DB::raw("YEAR(a_program_date) year, MONTH(a_program_date) month"),
            DB::raw("SUM($type) total"),
            'a_program_date',
        )->whereYear('a_program_date', date('Y'))
            ->where('a_branch_id', Auth::user()->branch)
            ->orderBy('month', 'ASC')
            ->groupby('year','month')
            ->get();
    }


    public function getBranchCurrentYearAttendance($branchId){
        return Attendance::where('a_branch_id', $branchId)
            ->whereYear('a_program_date', date('Y'))
            //->orderBy('a_id', 'DESC')
            ->get();
    }

    public function getBranchLastYearAttendance($branchId){
        $current = date('Y');
        return Attendance::where('a_branch_id', $branchId)
            ->whereYear('a_program_date', $current-1)
            ->get();
    }
    public function getLastYearAttendance(){
        $current = date('Y');
        return Attendance::whereYear('a_program_date', $current-1)
            ->get();
    }


    public function getBranchCurrentMonthAttendance($branchId){
        return Attendance::whereYear('a_program_date', date('Y'))
            ->whereMonth('a_program_date', date('m'))
            ->where('a_branch_id', $branchId)
            ->get();
    }

    public function getCurrentMonthAttendance(){
        return Attendance::whereYear('a_program_date', date('Y'))
            ->where('a_program_date', date('m'))
            ->get();
    }
    public function getBranchLastMonthAttendance($branchId){
        $currentMonth = date('m');
        $lastMonth = $currentMonth - 1;
        if($lastMonth == 0){
            $lastMonth = 12;
        }
        return Attendance::whereYear('a_program_date', date('Y'))
            ->whereMonth('a_program_date', $lastMonth)
            ->where('a_branch_id', $branchId)
            ->get();
    }

    public function getLastMonthAttendance(){
        $currentMonth = date('m');
        $lastMonth = $currentMonth - 1;
        if($lastMonth == 0){
            $lastMonth = 12;
        }
        return Attendance::whereYear('a_program_date', date('Y'))
            ->where('a_program_date', $lastMonth)
            ->get();
    }

    public function getAggregateAttendance(){
        return Attendance::all();
    }

    public function getBranchAllTimeAttendance($branchId){
        return Attendance::where('a_branch_id', $branchId)->get();
    }



}
