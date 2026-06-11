<?php

namespace App\Http\Controllers;

use App\DTOs\RegisterUserDTO;
use App\DTOs\UpdateUserDTO;
use App\Http\Requests\RegisterValidateRequest;
use App\UseCases\Users\DeleteUser;
use App\UseCases\Users\GetAllUsers;
use App\UseCases\Users\GetUserById;
use App\UseCases\Users\RegisterUser;
use App\UseCases\Users\UpdateUser;
use DomainException;
use Exception;
use Illuminate\Http\Request;

class RegisterUsersController extends Controller
{
    public function __construct(
        private RegisterUser $registerUser,
        private GetAllUsers $getAllUsers,
        private GetUserById $getUserById,
        private UpdateUser $updateUser,
        private DeleteUser $deleteUser
    ){}

    public function register(RegisterValidateRequest $request)
    {
        try{
            $data = $request->validated();

            $dto = new RegisterUserDTO(
                name: $data['name'],
                email: $data['email'],
                password: bcrypt($data['password']),
                role: $data['role']
            );

            $this->registerUser->execute($dto);
            return redirect()->route('login')->with('success', 'Registro realizado com sucesso. Faça login para continuar.');
        } catch(DomainException $e){
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return redirect()->back()->withErrors("Ocorreu um erro inesperado. Código do erro: $idError")->withInput();
        }
    }

    public function index()
    {
        $users = $this->getAllUsers->execute();
        return view('users.index', compact('users'));
    }

    public function show(int $id)
    {
        try{
            $users = $this->getUserById->execute($id);
            return view('users.show', compact('users'));
        }catch(DomainException $e){
            return redirect()->route('users.index')->withErrors($e->getMessage());
        }
    }

    public function edit(int $id)
    {
        $user = $this->getUserById->execute($id);
        return view('users.edit', compact('user'));
    }

    public function update(int $id, Request $request)
    {
        try{
            $data = $request->validated();
            $dto = new UpdateUserDTO(
                name: $data['name'],
                email: $data['email']
            );

            $this->updateUser->execute($id, $dto);
            return redirect()->route('users.show', ['id' => $id])->with('success', 'Usuário atualizado com sucesso');
        } catch(DomainException $e){
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(int $id)
    {
        try{
            $this->deleteUser->execute($id);
            return redirect()->route('users.index')->with('success', 'Usuário deletado com sucesso');
        } catch(DomainException $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
