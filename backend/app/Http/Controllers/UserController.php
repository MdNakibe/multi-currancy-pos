<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    private $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function Login(Request $req)
    {
        $username = $req->input('username');
        $password = $req->input('password');

        $login = $this->userRepo->Login($username, $password);

        if($login->code != 200) {
            return response()->json(['message' => $login->message], $login->code);
        }

        return response()->json([
            'message' => $login->message,
            'user' => $login->authorizedUser,
            'jwt' => $login->jwt,
        ], $login->code);
    }

    public function GetUsers(Request $req)
    {
        $users = $this->userRepo->Get($req->all());
        return response()->json(['users' => $users], 200);

    }

    public function CheckAuth()
    {
        // return app('userId');
        $user = User::select('id', 'user_type', 'permissions')->find(app('userId'));
        return response(['message' => 'Authenticated', 'user' => $user], 200);

    }

    public function AddUser(Request $req)
    {
        $user = new User();
        
        $userKey = ['name', 'phone', 'email', 'user_type', 'username', 'password'];
        
        foreach($userKey as $key) {
            $user->$key = $req->$key;
        }

        $res = $this->userRepo->Insert($user);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UpdateUser(Request $req)
    {
        $user = $this->userRepo->GetById($req->id);
        $userKey = ['name', 'phone', 'email', 'user_type', 'username', 'password', 'branch_id'];
        
        foreach($userKey as $key) {
            $user->$key = $req->$key;
        }

        $res = $this->userRepo->Update($user);
        return response()->json(['message' => $res->message], $res->code);
    } 

    public function UserProfileUpdate(Request $req)
    {
        $user = $this->userRepo->GetById($req->id);
        $reqUser = $req->all();
        $userKeys = array_keys((array)$req->all());

        foreach($userKeys as $key) {
            $user->$key = $reqUser[$key];
        }

        $res = $this->userRepo->UpdateProfile($user);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteUser($id)
    {
        $res = $this->userRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function UserPermissionUpdate(Request $req)
    {
        $user = $this->userRepo->GetById($req->id);
        $user->permissions = json_encode($req->permissions);

        $res = $this->userRepo->UserPermissions($user);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function BranchAccess(Request $req)
    {
        $res = $this->userRepo->BranchAccess($req->branchId);
        return response()->json([
            'message' => $res->message,
            'user' => $res->authorizedUser,
            'jwt' => $res->jwt
        ], $res->code);

    }
}
