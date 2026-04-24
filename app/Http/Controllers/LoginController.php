<?php

namespace App\Http\Controllers;

use App\DTOs\LoginDTO;
use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use App\UseCases\Auth\LoginUser;
use App\UseCases\Auth\LogoutUser;
use DomainException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct(
        private LoginUser $loginUser,
        private LogoutUser $logoutUser
    ){}

    public function login(LoginRequest $request)
    {
        try{
            $dto = new LoginDTO(...$request->validated());
            $result = $this->loginUser->execute($dto);
            return response()->json([
                'message' => 'Login realizado com sucesso.',
                'access_token' => $result['token'],
                'token_type' => 'Bearer',
                'expires_at' => $result['expires_at'],
                'user' => $result['user']
            ]);
        } catch(ValidationException $e){
            return response()->json([
                'message' => 'Credenciais inválidas.',
                'errors' => $e->errors()
            ], 422);
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'Erro interno.',
                'error_id' => $idError
            ], 500);
        }
    }

    public function logout()
    {
        try{
            $this->logoutUser->execute();
            return response()->json([
                'message' => 'Logout realizado com sucesso.'
            ]);
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'Erro interno.',
                'error_id' => $idError
            ], 500);
        }
    }
}
