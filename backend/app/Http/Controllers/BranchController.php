<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Branch;
use App\Repositories\BranchRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    private $branchRepo;
    private $imagePath = 'images';

    public function __construct(BranchRepository $branchRepo)
    {
        $this->branchRepo = $branchRepo;
    }

    public function GetBranches()
    {
        $branches = $this->branchRepo->Get();
        return response()->json(['branches' => $branches], 200);
    }

    public function AddBranch(Request $req)
    {
        $branch = new Branch();

        $reqBranch = json_decode($req->branch);
        $branchKeys = array_keys((array)$reqBranch);
  
        foreach($branchKeys as $key) {
            $branch->$key = $reqBranch->$key;
        }

        $imageName = '';
        if($req->hasFile('image')) {
            $imageName = (string)Str::uuid() . '.' . $req->image->extension();
            $req->image->move($this->imagePath, $imageName);
        }
        $imageName = !empty($imageName) ? $this->imagePath . '/' . $imageName : '';
        $branch->image = $imageName;
        
        $res = $this->branchRepo->Insert($branch);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateBranch(Request $req)
    {
        $reqBranch = json_decode($req->branch);
        $branch = $this->branchRepo->GetById($reqBranch->id);

        $branchKeys = array_keys((array)$reqBranch);
  
        foreach($branchKeys as $key) {
            $branch->$key = $reqBranch->$key;
        }

        $imageName = '';
        if($req->hasFile('image')) {
            File::delete($branch->image);
            $imageName = (string)Str::uuid() . '.' . $req->image->extension();
            $req->image->move($this->imagePath, $imageName);
        }
        $imageName = !empty($imageName) ? $this->imagePath . '/' . $imageName : $branch->image;
        $branch->image = $imageName;
        
        $res = $this->branchRepo->Update($branch);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteBranch($id)
    {
        $res = $this->branchRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }
}
