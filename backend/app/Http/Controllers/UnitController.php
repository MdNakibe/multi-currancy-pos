<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Repositories\UnitRepository;

class UnitController extends Controller
{
    private $unitRepo;

    public function __construct(UnitRepository $unitRepo)
    {
        $this->unitRepo = $unitRepo;
    }

    public function GetUnits()
    {
        $units = $this->unitRepo->Get();
        return response()->json(['units' => $units], 200);
    }

    public function AddUnit(Request $req)
    {
        $unit = new Unit();
        $unit->name = $req->name;
        $unit->added_by = 1;
        
        $res = $this->unitRepo->Insert($unit);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateUnit(Request $req)
    {
        $unit = $this->unitRepo->GetById($req->id);
        $unit->name = $req->name;
        $unit->updated_by = 1;

        $res = $this->unitRepo->Update($unit);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteUnit($id)
    {
        $res = $this->unitRepo->Delete($id);

        return response()->json(['message' => $res->message], $res->code);
    }
}
