<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $req){
        $data = $req->validate([
            'name'=> 'required',
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return apiResponse($data, 200, "register successfully");
    }

    public function login(Request $req){
        $data['email'] = $req->email;
        $data['password'] = $req->password;
        if(Auth::attempt(['email' =>$data['email'],'password' => $data['password']])){
            $data['token'] = Auth::user()->createToken('authToken')->plainTextToken;
            return apiResponse($data, 200, 'login successfully');
        }
    }

    public function getUser(){
        $data = User::all();
        return apiResponse($data, 200, 'getUser successfully');
    }

    public function getUserById($id) {
        $data = User::findOrFail($id);

        return apiResponse($data, 200, 'get data successfully');
    }
}
