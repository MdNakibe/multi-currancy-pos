<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Month;
use App\Repositories\MonthRepository;
use Illuminate\Http\Request;

class MonthController extends Controller
{
    private $monthRepo;

    public function __construct(MonthRepository $monthRepo)
    {
        $this->monthRepo = $monthRepo;
    }

    public function GetMonths()
    {
        $months = $this->monthRepo->Get();
        return response()->json(['months' => $months], 200);
    }

    public function AddMonth(Request $req)
    {
        $month = new Month();
        $month->name = $req->name;
        $month->added_by = app('userId');

        $res = $this->monthRepo->Insert($month);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateMonth(Request $req)
    {
        $month = $this->monthRepo->GetById($req->id);
        $month->name = $req->name;
        $month->updated_by = app('userId');

        $res = $this->monthRepo->Update($month);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteMonth($id)
    {
        $res = $this->monthRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }
}
