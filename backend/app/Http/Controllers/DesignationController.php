<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Repositories\DesignationRepository;

class DesignationController extends Controller
{
    private $designationRepo;

    public function __construct(DesignationRepository $designationRepo)
    {
        return $this->designationRepo = $designationRepo;   
    }

    public function GetDesignations()
    {
        $designations = $this->designationRepo->Get();
        return response()->json(['designations' => $designations], 200);
    }

    public function AddDesignation(Request $req)
    {
        $designation = new Designation();
        $designation->name = $req->name;
        $designation->added_by = app('userId');
        
        $res = $this->designationRepo->Insert($designation);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateDesignation(Request $req)
    {
        $designation = $this->designationRepo->GetById($req->id);
        $designation->name = $req->name;
        $designation->updated_by = app('userId');

        $res = $this->designationRepo->Update($designation);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteDesignation($id)
    {
        $res = $this->designationRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }
}
