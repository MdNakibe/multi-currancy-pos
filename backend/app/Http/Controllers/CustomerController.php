<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\CustomerType;
use App\Models\Sale;
use App\Repositories\CustomerRepository;

class CustomerController extends Controller
{
    private $customerRepo;

    public function __construct(CustomerRepository $customerRepo)
    {
        return $this->customerRepo = $customerRepo;   
    }

    public function GetCustomers(Request $req)
    {
        $customers = $this->customerRepo->Get($req->all());
        return response()->json(['customers' => $customers], 200);
    }

    public function GenerateCustomerCode()
    {
        $code = $this->customerRepo->GenerateCustomerCode();
        return response()->json(['code' => $code], 200);
    }

    public function AddCustomer(Request $req)
    {
        $customer = new Customer();

        $customerKeys = ['code', 'name', 'phone', 'email', 'area_id', 'address', 'customer_category_id', 'org_name', 'org_phone', 'credit_limit', 'type'];
        foreach($customerKeys as $key) {
            $customer->$key = $req->$key;
        }
        
        $res = $this->customerRepo->Insert($customer);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateCustomer(Request $req)
    {
        $customer = $this->customerRepo->GetById($req->id);

        $customerKeys = ['code', 'name', 'phone', 'email', 'area_id', 'address', 'org_name', 'customer_category_id', 'org_phone', 'credit_limit', 'type'];
        foreach($customerKeys as $key) {
            $customer->$key = $req->$key;
        }
        
        $res = $this->customerRepo->Update($customer);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteCustomer($id)
    {
        $res = $this->customerRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function GetCustomerPayment(Request $req)
    {
        $payments = $this->customerRepo->GetPayments($req->all());
        return response()->json(['payments' => $payments], 200);   
    }

    public function AddCustomerPayment(Request $req)
    {
        $payment = new CustomerPayment();
        $reqPayment = $req->all();
        $paymentKeys = array_keys((array)$req->all());

        foreach($paymentKeys as $key) {
            $payment->$key = $reqPayment[$key];
        }

        $res = $this->customerRepo->InsertPayment($payment);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateCustomerPayment(Request $req)
    {
        $payment = $this->customerRepo->GetByPaymentId($req->id);
        $reqPayment = $req->all();
        $paymentKeys = array_keys((array)$req->all());

        foreach($paymentKeys as $key) {
            $payment->$key = $reqPayment[$key];
        }

        $res = $this->customerRepo->UpdatePayment($payment);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteCustomerPayment($id)
    {
        $res = $this->customerRepo->DeletePayment($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function GetCustomerDue(Request $req)
    {
        $customers = $this->customerRepo->GetCustomerDue($req->all());
        return response()->json(['customers' => $customers], 200);
    }

    public function GetCustomerLedger(Request $req)
    {
        $res = $this->customerRepo->Ledger($req->all());
        return response()->json(['ledgers' => $res->ledgers, 'openingBalance' => $res->openingBalance], 200);
    }

    public function GetCustomerType()
    {
        $types = $this->customerRepo->GetTypes();
        return response()->json(['types' => $types], 200);
    }

    public function AddCustomerType(Request $req)
    {
        $type = new CustomerType();

        $typeKeys = ['name', 'discount', 'target'];
        foreach($typeKeys as $key) {
            $type->$key = $req->$key;
        }
        
        $res = $this->customerRepo->InsertType($type);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateCustomerType(Request $req)
    {
        $type = $this->customerRepo->GetByTypeId($req->id);

        $typeKeys = ['name', 'discount', 'target'];
        foreach($typeKeys as $key) {
            $type->$key = $req->$key;
        }
        
        $res = $this->customerRepo->UpdateType($type);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteCustomerType($id)
    {
        $res = $this->customerRepo->DeleteType($id);
        return response()->json(['message' => $res->message], $res->code);
    }
}
