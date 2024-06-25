<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PurchaseReturn;
use App\Repositories\PurchaseRepository;

class PurchaseController extends Controller
{
    private $purchaseRepo;

    public function __construct(PurchaseRepository $purchaseRepo)
    {
        $this->purchaseRepo = $purchaseRepo;
    }

    public function GetPurchase(Request $req)
    {
        $purchase = $this->purchaseRepo->Get($req->all());
        return response()->json(['purchases' => $purchase], 200);
    }

    public function GeneratePurchaseInvoice()
    {
        $invoice = $this->purchaseRepo->GeneratePurchaseInvoice();
        return response()->json(['invoice' => $invoice], 200);
    }

    public function GetPurchaseInvoice()
    {
        $invoice = $this->purchaseRepo->GetInvoice();
        return response()->json(['invoices' => $invoice], 200);
        
    }

    public function AddPurchase(Request $req)
    {
        $res = $this->purchaseRepo->Insert($req);
        return response()->json($res);
    }

    public function UpdatePurchase(Request $req)
    {
        $cart = $req->cart;
        $reqPurchase = (object)$req->purchase;
        $purchase = $this->purchaseRepo->GetById($reqPurchase->id);

        $purchaseKeys = array_keys((array)$req->purchase);

        foreach($purchaseKeys as $key) {
            $purchase->$key = $reqPurchase->$key;
        }

        $res = $this->purchaseRepo->Update($purchase, $cart);
        return response()->json(['message' => $res->message, 'id' => $res->id], $res->code);
    }

    public function DeletePurchase($id)
    {
        $res = $this->purchaseRepo->Delete($id);
        return response()->json(['message' => $res->message]);
    }

    public function GetPurchaseForReturn(Request $req)
    {
        $purchase = $this->purchaseRepo->GetPurchaseForReturn($req->all());
        return response()->json(['purchases' => $purchase], 200);
    }

    public function GetPurchaseReturns(Request $req)
    {
        $returns = $this->purchaseRepo->GetReturn($req->all());
        return response()->json(['returns' => $returns], 200);
    }

    public function AddPurchaseReturn(Request $req)
    {
        $purchaseReturn = new PurchaseReturn();
        $cart = $req->cart;
        $reqPurchase = (object)$req->purReturn;

        $purchaseKeys = array_keys((array)$req->purReturn);
        $purchaseKeys = array_filter($purchaseKeys, function ($key) {
            return $key != 'id';
        });

        foreach($purchaseKeys as $key) {
            $purchaseReturn->$key = $reqPurchase->$key;
        }

        $res = $this->purchaseRepo->InsertReturn($purchaseReturn, $cart);
        return response()->json(['message' => $res->message], $res->code);
    }
}
