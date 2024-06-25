<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    private $catRepo;

    public function __construct(CategoryRepository $catRepo)
    {
        $this->catRepo = $catRepo;
    }

    public function GetCategories()
    {
        $categories = $this->catRepo->Get();
        return response()->json(['categories' => $categories], 200);
    }

    public function AddCategory(Request $req)
    {
        $category = new Category();
        $category->name = $req->name;
        $category->description = $req->description;

        $res = $this->catRepo->Insert($category);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateCategory(Request $req)
    {
        $category = $this->catRepo->GetById($req->id);
        $category->name = $req->name;
        $category->description = $req->description;
       

        $res = $this->catRepo->Update($category);

        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteCategory($id)
    {
        $res = $this->catRepo->Delete($id);

        return response()->json(['message' => $res->message], $res->code);
    }
}
