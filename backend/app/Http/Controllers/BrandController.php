<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Repositories\BrandRepository;

class BrandController extends Controller
{
    private $brandRepo;

    public function __construct(BrandRepository $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    public function GetBrands()
    {
        $brands = $this->brandRepo->Get();
        return response()->json(['brands' => $brands], 200);
    }

    public function AddBrand(Request $req)
    {
        $brand = new Brand();
        $brand->name = $req->name;
        
        $res = $this->brandRepo->Insert($brand);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateBrand(Request $req)
    {
        $brand = $this->brandRepo->GetById($req->id);
        $brand->name = $req->name;

        $res = $this->brandRepo->Update($brand);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteBrand($id)
    {
        $res = $this->brandRepo->Delete($id);

        return response()->json(['message' => $res->message], $res->code);
    }
}
