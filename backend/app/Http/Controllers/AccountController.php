<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CashTransaction;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Repositories\AccountRepository;

class AccountController extends Controller
{
    private $accountRepo;

    public function __construct(AccountRepository $accountRepo)
    {
        $this->accountRepo = $accountRepo;
    }

    public function GetExpenses()
    {
        $expenses = $this->accountRepo->GetExpense();
        return response()->json(['expenses' => $expenses], 200);
    }

    public function AddExpense(Request $req)
    {
        $expense = new Expense();
        $expense->name = $req->name;
        $expense->description = $req->description;
        $expense->added_by = 1;
        $expense->branch_id = 1;

        $res = $this->accountRepo->Insert($expense);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateExpense(Request $req)
    {
        $expense = $this->accountRepo->GetByExpenseId($req->id);
        $expense->name = $req->name;
        $expense->description = $req->description;
        $expense->updated_by = 1;
        $expense->branch_id = 1;

        $res = $this->accountRepo->UpdateExpense($expense);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteExpense($id)
    {
        $res = $this->accountRepo->DeleteExpense($id);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function GetCashTransactions(Request $req)
    {
        $transactions = $this->accountRepo->GetTransaction($req->all());
        return response()->json(['transactions' => $transactions], 200);
    }

    public function AddCashTransaction(Request $req)
    {
        $transaction = new CashTransaction();

        $transactionKeys = ['code', 'account_id', 'type', 'date', 'note'];
        foreach($transactionKeys as $key) {
            $transaction->$key = $req->$key;
        }

        if($req->type == 'Cash Receive') {
            $transaction->received_amount = $req->amount;
            $transaction->paid_amount = 0;
        } else if($req->type == 'Cash Payment') {
            $transaction->received_amount = 0;
            $transaction->paid_amount =  $req->amount;
        }
        
        $res = $this->accountRepo->InsertCashTransaction($transaction);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateCashTransaction(Request $req)
    {
        $transaction = $this->accountRepo->GetByTransactionId($req->id);
        $transactionKeys = ['code', 'account_id', 'type', 'date', 'note'];
        foreach($transactionKeys as $key) {
            $transaction->$key = $req->$key;
        }

        if($req->type == 'Cash Receive') {
            $transaction->received_amount = $req->amount;
            $transaction->paid_amount = 0;
        } else if($req->type == 'Cash Payment') {
            $transaction->received_amount = 0;
            $transaction->paid_amount =  $req->amount;
        }
        
        $res = $this->accountRepo->UpdateCashTransaction($transaction);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteCashTransaction($id)
    {
        $res = $this->accountRepo->DeleteTransaction($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function GenerateTransactionCode()
    {
        $code = $this->accountRepo->GenerateTransactionCode();
        return response()->json(['code' => $code], 200);
    }

    public function GetCashBalance()
    {
        $balance = $this->accountRepo->GetCashBalance();
        return response()->json(['balance' => $balance], 200); 
    }

    public function CashLedger(Request $req)
    {
        $cash = $this->accountRepo->GetCashLedger($req->all());
        return response()->json(['cash' => $cash], 200);
    }

    public function GhrapData()
    {
        $records = $this->accountRepo->Ghrap();
        return $records;
    }

    public function GetProfit()
    {
        $profit = $this->accountRepo->ProfitLoss();
        return response()->json(['profit' => $profit], 200);
    }

}
