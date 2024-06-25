<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CompanyProfileRepository;

class CompanyProfileController extends Controller
{
    protected $companyProfileRepo;

    private $imagePath = 'images';

    public function __construct(CompanyProfileRepository $companyProfileRepo)
    {
        $this->companyProfileRepo = $companyProfileRepo;
    }

    public function GetCompanyProfile()
    {
        $companyProfile = $this->companyProfileRepo->Get();
        return response()->json(['company_profile' => $companyProfile], 200);
    }

    public function UpdateCompanyProfile(Request $req)
    {
        $reqCompany = json_decode($req->input('company'), true);
        $company = $this->companyProfileRepo->Get();
        $imageName = '';
        if($req->hasFile('image')) {
            // File::delete($company->image);
            $imageName = (string)Str::uuid() . '.' . $req->image->extension();
            $req->image->move($this->imagePath, $imageName);
        }

        $_imagePath = !empty($imageName) ? $this->imagePath . "/" . $imageName : '';
        
        $res = $this->companyProfileRepo->Update($reqCompany, $_imagePath);
        // return $res;
        return response(['message' => $res->message], 200);
    }

}
