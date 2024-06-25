<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Repositories\AttendanceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class AttendanceController extends Controller
{
    private $attendanceRepo;

    public function __construct(AttendanceRepository $attendanceRepo)
    {
        $this->attendanceRepo = $attendanceRepo;
    }

    public function GetAttendance()
    {
        $attendances = $this->attendanceRepo->Get();
        return response()->json(['attendances' => $attendances], 200);
    }

    public function AddAttendance(Request $req)
    {
        $res = new stdClass;
        $employee = Employee::where('emp_id', $req->employee_id)->first();
        if (!$employee) {
            return response()->json(['message' => 'Employee id is incorrect'], 500);
        }

        $existAttendance = Attendance::where('employee_id', $employee->id)
                                            ->whereDate('created_at', now()) 
                                            ->orderBy('created_at', 'DESC')
                                            ->first();
        if ($existAttendance) {
            if ($req->type == 'clockin' && $existAttendance->clock_in != null) {
                return response()->json(['message' => 'Already clocked in.'], 500);
            }
            if ($req->type == 'clockout') {
                if ($existAttendance->clock_out) {
                    return response()->json(['message' => 'Already clocked out.'], 500);
                }
                $existAttendance->update([
                    'clock_out' => now(),
                    'duration' => now()->diffInMinutes($existAttendance->clock_in)
                ]);
                return response()->json(['message' => 'Saved Successfully'], 200);
            }
        } elseif($req->type == 'clockout') {
            return response()->json(['message' => 'You are not checked in'], 500);
        }


        try {
            DB::beginTransaction();
    
            if($req->type == 'clockin') {
    
                $attendance = new Attendance();
                $attendance->employee_id = $employee->id;
                $attendance->clock_in = now();
                $attendance->note = $req->note ?? '';
    
                $attendance->added_by = app('userId');
                
                $attendance->save();
                $res->message = 'Saved successfully';
                $res->code = 200;
            }

            DB::commit();
            $res->message = 'Saved successfully';
            $res->code = 200;
        } catch (\Throwable $th) {
            DB::rollBack();
            $res->code = 500;
            $res->message = $th->getMessage();
        }

        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateAttendance(Request $req)
    {
        $attendance = $this->attendanceRepo->GetById($req->input('id'));
        // $attendance->updated_by
        $attendance->employee_id = $req->employee_id;
        $attendance->type = $req->type;
        $attendance->note = $req->note;
        $attendance->attempt_time = $req->attempt_time;

        $attendance->added_by = app('userId');
        $attendance->updated_by = app('userId');

        $res = $this->attendanceRepo->Update($attendance);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteAttendance($id)
    {
        $res = $this->attendanceRepo->Delete($id);

        return response()->json(['message' => $res->message], $res->code);
    }
}
