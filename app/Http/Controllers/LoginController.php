<?php

namespace App\Http\Controllers;

use App\DTOs\LoginDTO;
use App\Http\Requests\LoginRequest;
use App\UseCases\Auth\LoginUser;
use App\UseCases\Auth\LogoutUser;
use Exception;
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
            $dto = new LoginDTO(
                email: $request->validated()['email'],
                password: $request->validated()['password']
            );
            $this->loginUser->execute($dto);
            return redirect()->route('dashboard')->with('success', 'Login realizado com sucesso.');
        } catch(ValidationException $e){
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return back()->with('error', 'Erro interno. Código do erro: ' . $idError);
        }
    }

    public function logout()
    {
        try{
            $this->logoutUser->execute();
            return redirect()->route('login')->with('success', 'Logout realizado com sucesso.');
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return redirect()->back()->with('error', 'Erro interno. Código do erro: ' . $idError);
        }
    }
}
