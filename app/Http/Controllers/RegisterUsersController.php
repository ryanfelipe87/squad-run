<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterValidateRequest;
use App\Services\RegisterUsersService;
use Illuminate\Http\Request;

class RegisterUsersController extends Controller
{
    protected $registerUsersService;

    public function __construct(RegisterUsersService $registerUsersService){
        $this->registerUsersService = $registerUsersService;
    }

    public function index(){
        return view('register.register');
    }

    public function register(RegisterValidateRequest $request){
        $response = $this->registerUsersService->register($request->validated());
        return response()->json($response, 201);
    }

    public function getAllUsers(){
        $response = $this->registerUsersService->getAllUsers();
        return response()->json($response, 200);
    }

    public function getUserById($id){
        $response = $this->registerUsersService->getUserById($id);
        return response()->json($response, 200);
    }
}
