<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankTransaction;
use Illuminate\Http\Request;
use App\Repositories\BankRepository;

class BankController extends Controller
{
    private $bankRepo;

    public function __construct(BankRepository $bankRepo)
    {
        $this->bankRepo = $bankRepo;
    }

    public function GetBankAccounts()
    {
        $accounts = $this->bankRepo->GetBankAccount();
        return response()->json(['accounts' => $accounts], 200);
    }

    public function AddBankAccount(Request $req)
    {
        $account = new BankAccount();
        
        $bankAccountKeys = ['account_name', 'account_number', 'account_type', 'bank_name', 'branch_name', 'initial_balance', 'description', 'branch_id'];
        foreach($bankAccountKeys as $key) {
            $account->$key = $req->$key;
        }
        
        $res = $this->bankRepo->InsertBankAccount($account);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateBankAccount(Request $req)
    {
        $account = $this->bankRepo->GetBankAccountById($req->id);

        $bankAccountKeys = ['account_name', 'account_number', 'account_type', 'bank_name', 'branch_name', 'initial_balance', 'description', 'branch_id'];
        foreach($bankAccountKeys as $key) {
            $account->$key = $req->$key;
        }
        
        $res = $this->bankRepo->UpdateBankAccount($account);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteBankAccount($id)
    {
        $res = $this->bankRepo->DeleteBankAccount($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function GenerateBankTransactionCode()
    {
        $code = $this->bankRepo->GenerateTransactionCode();
        return response()->json(['code' => $code], 200);
    }

    public function GetBankTransaction(Request $req)
    {
        $transactions = $this->bankRepo->GetTransaction($req->all());
        return response()->json(['transactions' => $transactions], 200);
    }

    public function AddBankTrnasaction(Request $req)
    {
        $transaction = new BankTransaction();

        $transactionKeys = ['code', 'date', 'account_id', 'type',  'amount', 'note'];
        foreach($transactionKeys as $key) {
            $transaction->$key = $req->$key;
        }
        
        $res = $this->bankRepo->InsertBankTransaction($transaction);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateBankTrnasaction(Request $req)
    {
        $transaction = $this->bankRepo->GetByTransactionId($req->id);
        $transactionKeys = ['code', 'date', 'account_id', 'type',  'amount', 'note'];
        foreach($transactionKeys as $key) {
            $transaction->$key = $req->$key;
        }
        
        $res = $this->bankRepo->UpdateBankTransaction($transaction);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteBankTrnasaction($id)
    {
        $res = $this->bankRepo->DeleteBankTransaction($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function GetCurrentBalance(Request $req)
    {
        $balance = $this->bankRepo->GetCurrentBalance($req->all());
        return response()->json(['balance' => $balance], 200);
    }

    public function GetBankBalance()
    {
        $balance = $this->bankRepo->CalculateBankBalance();
        return response()->json(['balance' => $balance], 200);
    }

    public function GetAccountBalance()
    {
        $balance = $this->bankRepo->GetBankBalance();
        return response()->json(['banks' => $balance], 200);
    }

    public function GetBankLedger(Request $req)
    {
        $ledger = $this->bankRepo->GetBankLedger($req->all());
        return response()->json(['bank' => $ledger], 200);
    }
}
