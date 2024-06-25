<?php

namespace App\Http\Controllers;

use App\Models\CustomerCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CustomerCategoryRepository;

class CustomerCategoryController extends Controller
{
    private $catRepo;

    public function __construct(CustomerCategoryRepository $catRepo)
    {
        $this->catRepo = $catRepo;
    }

    public function GetCustomerCategories()
    {
        $categories = $this->catRepo->Get();
        return response()->json(['customer_categories' => $categories], 200);
    }

    public function AddCustomerCategory(Request $req)
    {
        $Customercategory = new CustomerCategory();
        $Customercategory->name = $req->name;

        $res = $this->catRepo->Insert($Customercategory);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateCustomerCategory(Request $req)
    {
        $Customercategory = $this->catRepo->GetById($req->id);
        $Customercategory->name = $req->name;
       

        $res = $this->catRepo->Update($Customercategory);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteCustomerCategory($id)
    {
        $res = $this->catRepo->Delete($id);

        return response()->json(['message' => $res->message], $res->code);
    }
}
