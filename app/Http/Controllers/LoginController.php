<?php

namespace App\Http\Controllers;

use App\DTOs\LoginDTO;
use App\DTOs\RefreshTokenDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshTokenRequest;
use App\UseCases\Auth\LoginUser;
use App\UseCases\Auth\LogoutUser;
use App\UseCases\Auth\RefreshToken;
use Exception;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct(
        private LoginUser $loginUser,
        private LogoutUser $logoutUser,
        private RefreshToken $refreshToken
    ){}

    public function login(LoginRequest $request)
    {
        try{
            $dto = new LoginDTO(...$request->validated());
            $result = $this->loginUser->execute($dto);
            return response()->json([
                'message' => 'Login realizado com sucesso.',
                'access_token' => $result['access_token'],
                'refresh_token' => $result['refresh_token'],
                'token_type' => 'Bearer',
                'expires_at' => $result['expires_at']->toDateTimeString(),
                'user' => $result['user']
            ]);
        } catch(ValidationException $e){
            return response()->json([
                'message' => 'Credenciais inválidas.',
                'errors' => $e->errors()
            ], 401);
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

    public function refresh(RefreshTokenRequest $request)
    {
        try {
            $dto = new RefreshTokenDTO($request->validated()['refresh_token']);

            $result = $this->refreshToken->execute($dto);

            return response()->json([
                'access_token' => $result['access_token'],
                'token_type' => 'Bearer',
                'expires_at' => $result['expires_at']->toDateTimeString()
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Token inválido',
                'errors' => $e->errors()
            ], 401);

        } catch (Exception $e) {
            $idError = logErro($e->getMessage());

            return response()->json([
                'message' => 'Erro interno',
                'error_id' => $idError
            ], 500);
        }
    }
}
