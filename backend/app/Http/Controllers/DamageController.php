<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Damage;
use App\Repositories\DamageRepository;
use Illuminate\Http\Request;

class DamageController extends Controller
{
    private $damageRepo;

    public function __construct(DamageRepository $damageRepo)
    {
        return $this->damageRepo = $damageRepo;
    }

    public function GenerateDamageCode()
    {
        $invoice = $this->damageRepo->GenerateDamageInvoice();
        return response()->json(['invoice' => $invoice], 200);
    }

    public function GetDamages(Request $req)
    {
        $damages = $this->damageRepo->Get($req->all());
        return response()->json(['damages' => $damages], 200);
    }

    public function AddDamage(Request $req)
    {
        $damage = new  Damage();
        $cart = $req->cart;
        $reqDamage = (object)$req->damage;

        $damageKeys = array_keys((array)$req->damage);

        foreach($damageKeys as $key) {
            $damage->$key = $reqDamage->$key;
        }

        $res = $this->damageRepo->Insert($damage, $cart);
        return response()->json(['message' => $res->message, 'id' => $res->id], $res->code);
    }

    public function UpdateDamage(Request $req)
    {
        $cart = $req->cart;
        $reqDamage = (object)$req->damage;
        $damage = $this->damageRepo->GetById($reqDamage->id);

        $damageKeys = array_keys((array)$req->damage);

        foreach($damageKeys as $key) {
            $damage->$key = $reqDamage->$key;
        }

        $res = $this->damageRepo->Update($damage, $cart);
        return response()->json(['message' => $res->message, 'id' => $res->id], $res->code);
    }

    public function DeleteDamage($id)
    {
        $res = $this->damageRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }
}
