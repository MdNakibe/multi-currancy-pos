<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Repositories\SaleRepository;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    private $saleRepo;

    public function __construct(SaleRepository $saleRepo)
    {
        return $this->saleRepo = $saleRepo;
    }

    public function GetSales(Request $req)
    {
        $sale = $this->saleRepo->Get($req->all());
        return response()->json(['sales' => $sale], 200);
    }

    public function GenerateSaleInvoice()
    {
        $invoice = $this->saleRepo->GenerateSaleInvoice();
        return response()->json(['invoice' => $invoice], 200);
    }

    public function GetSaleInvoice()
    {
        $invoice = $this->saleRepo->GetInvoice();
        return response()->json(['invoices' => $invoice], 200);
        
    }

    public function AddSale(Request $req)
    {
        $sale = new  Sale();
        $cart = $req->cart;
        $customer = $req->customer;
        $reqSale = (object)$req->sale;

        $saleKeys = array_keys((array)$req->sale);
        $saleKeys = array_filter($saleKeys, function ($key) {
            return $key != 'id';
        });

        foreach($saleKeys as $key) {
            $sale->$key = $reqSale->$key;
        }

        $res = $this->saleRepo->Insert($sale, $cart, $customer);
        return $res;
        return response()->json(['message' => $res->message, 'id' => $res->id], $res->code);
    }

    public function UpdateSale(Request $req)
    {
        $cart = $req->cart;
        $reqSale = (object)$req->sale;
        $sale = $this->saleRepo->GetById($reqSale->id);

        $saleKeys = array_keys((array)$req->sale);

        foreach($saleKeys as $key) {
            $sale->$key = $reqSale->$key;
        }

        $res = $this->saleRepo->Update($sale, $cart);
        return response()->json(['message' => $res->message, 'id' => $res->id], $res->code);
    }

    public function DeleteSale($id)
    {
        $res = $this->saleRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function GetSaleForReturn(Request $req)
    {
        $sales = $this->saleRepo->GetSaleForReturn($req->all());
        return response()->json(['sales' => $sales], 200);
    }

    public function GetSaleReturn(Request $req)
    {
        $returns = $this->saleRepo->GetReturn($req->all());
        return response()->json(['returns' => $returns], 200);
    }

    public function AddSaleReturn(Request $req)
    {
        $saleReturn = new SaleReturn();
        $cart = $req->cart;
        $reqPurchase = (object)$req->saleReturn;

        $purchaseKeys = array_keys((array)$req->saleReturn);

        foreach($purchaseKeys as $key) {
            $saleReturn->$key = $reqPurchase->$key;
        }

        $res = $this->saleRepo->InsertReturn($saleReturn, $cart);
        return response()->json(['message' => $res->message], $res->code);
    }
}
