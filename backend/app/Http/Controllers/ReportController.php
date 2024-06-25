<?php

namespace App\Http\Controllers;

use App\Repositories\ReportRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct(
        public ReportRepository $reportRepo
    ) {}
    public function profitloss(Request $request) {
        $res = $this->reportRepo->GetProfitLoss($request);
        return response()->json(['profitloss' => $res->profitloss], $res->code);
    }
}
