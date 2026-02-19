<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterValidateRequest;
use App\Services\RegisterUsersService;
use DomainException;
use Exception;
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
        try{
            $data = $request->validated();
            $response = $this->registerUsersService->register($data);
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while registering the user.',
                'error_id' => $idError
            ], 500);
        }

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

    public function updateUserById($id, Request $request){
        try{
            $response = $this->registerUsersService->updateUserById($id, $request->all());
        } catch(DomainException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while updating the user.',
                'error_id' => $idError
            ], 500);
        }

        return response()->json($response, 200);
    }

    public function deleteUserById($id){
        try{
            $response = $this->registerUsersService->deleteUserById($id);
        } catch(DomainException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while deleting the user.',
                'error_id' => $idError
            ], 500);
        }

        return response()->json($response, 200);
    }
}
