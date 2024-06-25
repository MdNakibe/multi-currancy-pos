<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Repositories\SupplierRepository;

class SupplierController extends Controller
{
    private $supplierRepo;

    public function __construct(SupplierRepository $supplierRepo)
    {
        return $this->supplierRepo = $supplierRepo;
    }

    public function GetSuppliers()
    {
        $suppliers = $this->supplierRepo->Get();
        return response()->json(['suppliers' => $suppliers], 200);
    }

    public function GenerateSupplierCode()
    {
        $code = $this->supplierRepo->GenerateSupplierCode();
        return response()->json(['code' => $code], 200);
    }

    public function AddSupplier(Request $req)
    {   
        $supplier = new Supplier();

        $supplierKeys = ['code', 'name', 'phone', 'email', 'area_id', 'address', 'org_name', 'org_phone', 'credit_limit'];
        foreach($supplierKeys as $key) {
            $supplier->$key = $req->$key;
        }
        
        $res = $this->supplierRepo->Insert($supplier);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateSupplier(Request $req)
    {
        $supplier = $this->supplierRepo->GetById($req->id);

        $supplierKeys = ['code', 'name', 'phone', 'email', 'area_id', 'address', 'org_name', 'org_phone', 'credit_limit'];
        foreach($supplierKeys as $key) {
            $supplier->$key = $req->$key;
        }
        
        $res = $this->supplierRepo->Update($supplier);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteSupplier($id)
    {
        $res = $this->supplierRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function GetSupplierPayment(Request $req)
    {
        $payments = $this->supplierRepo->GetPayments($req->all());
        return response()->json(['payments' => $payments], 200);
    }

    public function AddSupplierPayment(Request $req)
    {
        $payment = new SupplierPayment();
        $reqPayment = $req->all();
        $paymentKeys = array_keys((array)$req->all());

        foreach($paymentKeys as $key) {
            $payment->$key = $reqPayment[$key];
        }

        $res = $this->supplierRepo->InsertPayment($payment);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateSupplierPayment(Request $req)
    {
        $payment = $this->supplierRepo->GetByPaymentId($req->id);
        $reqPayment = $req->all();
        $paymentKeys = array_keys((array)$req->all());

        foreach($paymentKeys as $key) {
            $payment->$key = $reqPayment[$key];
        }

        $res = $this->supplierRepo->UpdatePayment($payment);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteSupplierPayment($id)
    {
        $res = $this->supplierRepo->DeletePayment($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function SupplierDue(Request $req)
    {
        $suppliers = $this->supplierRepo->GetSupplierDue($req->all());
        return response()->json(['suppliers' => $suppliers], 200);
    }

    public function GetSupplierLedger(Request $req)
    {
        $res = $this->supplierRepo->Ledger($req->all());
        return response()->json(['ledgers' => $res->ledgers, 'openingBalance' => $res->openingBalance], 200);
    }
}
