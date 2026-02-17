<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $loginService;

    public function __construct(LoginService $loginService){
        $this->loginService = $loginService;
    }

    public function index(){
        return view('login.login');
    }

    public function login(LoginRequest $request){
        $credentials = $request->validated();
        $response = $this->loginService->login($credentials);
        return response()->json($response, 200);
    }
}
