<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    private $deptRepo;

    public function __construct(DepartmentRepository $deptRepo)
    {
        return $this->deptRepo = $deptRepo;
    }

    public function GetDepartments()
    {
        $departments = $this->deptRepo->Get();
        return response()->json(['departments' => $departments], 200);
    }

    public function AddDepartment(Request $req)
    {
        $department = new Department();
        $department->name = $req->name;
        $department->added_by = app('userId');
        
        $res = $this->deptRepo->Insert($department);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateDepartment(Request $req)
    {
        $department = $this->deptRepo->GetById($req->id);
        $department->name = $req->name;
        $department->updated_by = app('userId');

        $res = $this->deptRepo->Update($department);

        return response()->json(['message' => $res->message], $res->code);

    }

    public function DeleteDepartment($id)
    {
        $res = $this->deptRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }
}
