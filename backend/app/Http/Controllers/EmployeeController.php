<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SalaryPayment;
use App\Models\SalarySheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    private $employeeRepo;
    private $imagePath = 'images/employee';

    public function __construct(EmployeeRepository $employeeRepo)
    {
        return $this->employeeRepo = $employeeRepo;
    }

    public function GetEmployees(Request $req)
    {
        $employees = $this->employeeRepo->Get($req->all());
        return response()->json(['employees' => $employees], 200);
    }

    public function GenerateEmployeeCode() 
    {
        $code = $this->employeeRepo->GenerateEmployeeCode();
        return response()->json(['code' => $code], 200);
    }

    public function AddEmployee(Request $req)
    {
        $reqEmployee = json_decode($req->input('employee'));

        $employee = new Employee();

        $employeeKeys = array_keys((array)$reqEmployee);
        foreach($employeeKeys as $key) {
            $employee->$key = $reqEmployee->$key;
        }

        $imageName = '';
        $signature = '';
        $nominee = '';

        if ($req->hasFile('image')) {
            $imageName = (string)Str::uuid() . '.' . $req->image->extension();
            $req->image->move($this->imagePath, $imageName);
        }
        $imageName = !empty($imageName) ? $this->imagePath . '/' . $imageName : '';

        if ($req->hasFile('signature')) {
            $signature = (string)Str::uuid() . '.' . $req->signature->extension();
            $req->signature->move($this->imagePath, $signature);
        }
        $signature = !empty($signature) ? $this->imagePath . '/' . $signature : '';

        if ($req->hasFile('nominee')) {
            $nominee = (string)Str::uuid() . '.' . $req->nominee->extension();
            $req->nominee->move($this->imagePath, $nominee);
        }
        $nominee = !empty($nominee) ? $this->imagePath . '/' . $nominee : '';

        $employee->image = $imageName;
        $employee->signature_image = $signature;
        $employee->nominee_image = $nominee;

        $res = $this->employeeRepo->Insert($employee);
        return response()->json(['message' => $res->message], $res->code);
    }   

    public function UpdateEmployee(Request $req)
    {
        $reqEmployee = json_decode($req->input('employee'));

        $employee = $this->employeeRepo->GetById($reqEmployee->id);

        $employeeKeys = array_keys((array)$reqEmployee);
        foreach($employeeKeys as $key) {
            $employee->$key = $reqEmployee->$key;
        }

        $imageName = '';
        $signature = '';
        $nominee = '';

        if ($req->hasFile('image')) {
            File::delete($employee->image);
            $imageName = (string)Str::uuid() . '.' . $req->image->extension();
            $req->image->move($this->imagePath, $imageName);
        }
        $imageName = !empty($imageName) ? $this->imagePath . '/'. $imageName : $employee->image;


        if ($req->hasFile('signature')) {
            File::delete($employee->signature_image);
            $signature = (string)Str::uuid() . '.' . $req->signature->extension();
            $req->signature->move($this->imagePath, $signature);
        }
        $signature = !empty($signature) ? $this->imagePath . '/'. $signature : $employee->signature_image;

        if ($req->hasFile('nominee')) {
            File::delete($employee->nominee_image);
            $nominee = (string)Str::uuid() . '.' . $req->nominee->extension();
            $req->nominee->move($this->imagePath, $nominee);
        }
        $nominee = !empty($nominee) ? $this->imagePath . '/'. $nominee : $employee->nominee_image;

        $employee->image = $imageName;
        $employee->signature_image = $signature;
        $employee->nominee_image = $nominee;

        $res = $this->employeeRepo->Update($employee);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteEmployee($id)
    {
        $res = $this->employeeRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function AddSalaryGenerate(Request $req)
    {
        $salary = new SalarySheet();
        $cart = $req->cart;
        $reqSalary = (object)$req->salary;

        $salaryKeys = array_keys((array)$req->salary);
        foreach($salaryKeys as $key) {
            $salary->$key = $reqSalary->$key;
        }
        
        $salary->year = Carbon::createFromDate($salary->date)->format('Y');

        $res = $this->employeeRepo->SalaryGenerate($salary, $cart);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function GetSalaryPayment(Request $req)
    {
        $payments = $this->employeeRepo->GetPayments($req->all());
        return response()->json(['payments' => $payments], 200);
    }

    public function AddSalaryPayment(Request $req)
    {
        $payment = new SalaryPayment();
        $reqPayment = $req->all();
        $paymentKeys = array_keys((array)$req->all());

        foreach($paymentKeys as $key) {
            $payment->$key = $reqPayment[$key];
        }

        $res = $this->employeeRepo->InsertPayment($payment);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateSalaryPayment(Request $req)
    {
        $payment = $this->employeeRepo->GetByPaymentId($req->id);
        $reqPayment = $req->all();
        $paymentKeys = array_keys((array)$req->all());

        foreach($paymentKeys as $key) {
            $payment->$key = $reqPayment[$key];
        }

        $res = $this->employeeRepo->UpdatePayment($payment);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteSalaryPayment($id)
    {
        $res = $this->employeeRepo->DeletePayment($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function GetSalaryDue(Request $req)
    {
        $salary = $this->employeeRepo->GetSalaryDue($req->all());
        return response()->json(['salary' => $salary], 200);
    }

    public function GetSalarySheet(Request $req)
    {
        $sheets = $this->employeeRepo->GetSalarySheet($req->all());
        return response()->json(['sheets' => $sheets], 200);
    }
    
    private function salaryCalculate(){
        
    }

    // employee discount code store
    public function AddEmployeeDiscountCode(Request $req){
        $reqEmployee = json_decode($req->input('employee'));
        $employee = $this->employeeRepo->GetById($reqEmployee->id);

        $res = $this->employeeRepo->AddEmployeeDiscountCode($employee);
    }
}
