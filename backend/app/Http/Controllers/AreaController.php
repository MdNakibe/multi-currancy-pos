<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Repositories\AreaRepository;

class AreaController extends Controller
{
    private $areaRepo;

    public function __construct(AreaRepository $areaRepo)
    {
        $this->areaRepo = $areaRepo;
    }

    public function GetAreas()
    {
        $areas = $this->areaRepo->Get();
        return response()->json(['areas' => $areas], 200);
    }

    public function AddArea(Request $req)
    {
        $area = new Area();
        $area->name = $req->name;
        $area->added_by = app('userId');
        
        $res = $this->areaRepo->Insert($area);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateArea(Request $req)
    {
        $area = $this->areaRepo->GetById($req->input('id'));
        $area->name = $req->input('name');
        $area->updated_by = app('userId');

        $res = $this->areaRepo->Update($area);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteArea($id)
    {
        $res = $this->areaRepo->Delete($id);

        return response()->json(['message' => $res->message], $res->code);
    }
}
