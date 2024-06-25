<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cheque;
use Illuminate\Http\Request;
use App\Repositories\ChequeRepository;

class ChequeController extends Controller
{
    private $chequeRepo;

    public function __construct(ChequeRepository $chequeRepo)
    {
        $this->chequeRepo = $chequeRepo;
    }

    public function GetCheques(Request $req)
    {
        $cheques = $this->chequeRepo->Get($req->all());
        return response()->json(['cheques' => $cheques], 200);
    }

    public function AddCheque(Request $req)
    {
       
        $cheque = new Cheque();

        $chequeKeys = ['customer_id', 'bank_name', 'branch_name', 'cheque_number', 'cheque_amount', 'cheque_status', 'date', 'cheque_date', 'reminder_date', 'submit_date', 'note'];
        foreach($chequeKeys as $key) {
            $cheque->$key = $req->$key;
        }
        
        $res = $this->chequeRepo->Insert($cheque);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateCheque(Request $req)
    {
        $cheque = $this->chequeRepo->GetById($req->id);

        $chequeKeys = ['customer_id', 'bank_name', 'branch_name', 'cheque_number', 'cheque_amount', 'cheque_status', 'date', 'cheque_date', 'reminder_date', 'submit_date', 'note'];
        foreach($chequeKeys as $key) {
            $cheque->$key = $req->$key;
        }
        
        $res = $this->chequeRepo->Update($cheque);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteCheque($id)
    {
        $res = $this->chequeRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function ChangeChequeStatus(Request $req)
    {
        $res = $this->chequeRepo->ChangeStatus($req->id);
        return response(['message' => $res->message], $res->code);
    }
}
