<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Repositories\DiscountCodeRepository;
use Illuminate\Http\Request;

class DiscountCodeController extends Controller
{
    public $discRepo;
    public function __construct(DiscountCodeRepository $discRepo) {
        $this->discRepo = $discRepo;
    }

    public function GetDiscountCode(Request $req) {
        $discount_code = $this->discRepo->Get($req->all());
        return response()->json(['discount_code' => $discount_code], 200);
    }

    public function AddDiscountCode(Request $req) {
        $reqDiscount = $req->discount_code;

        $discount_code = new DiscountCode();

        $discKeys = array_keys((array)$reqDiscount);
        foreach($discKeys as $key) {
            $discount_code->$key = $reqDiscount[$key];
        }

        $res = $this->discRepo->Insert($discount_code);
        return response()->json(['message' => $res->message], $res->code);
    }
    public function UpdateExpense(Request $req) {}
    public function DeleteExpense($id) {
        $res = $this->discRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }
}
