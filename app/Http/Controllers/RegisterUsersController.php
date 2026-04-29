<?php

namespace App\Http\Controllers;

use App\DTOs\RegisterUserDTO;
use App\DTOs\UpdateUserDTO;
use App\Http\Requests\RegisterValidateRequest;
use App\Services\RegisterUsersService;
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

    public function register(RegisterValidateRequest $request){
        try{
            $data = $request->validated();

            $dto = new RegisterUserDTO(
                name: $data['name'],
                email: $data['email'],
                password: bcrypt($data['password']),
                role: $data['role']
            );

            $user = $this->registerUser->execute($dto);
            return response()->json([
                'message' => 'Usuário registrado com sucesso.',
                'data' => $user
            ], 201);
        } catch(DomainException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'Erro interno.',
                'error_id' => $idError
            ], 500);
        }
    }

    public function index(){
        return response()->json([
            'data' => $this->getAllUsers->execute()
        ]);
    }

    public function show(int $id){
        try{
            return response()->json([
                'data' => $this->getUserById->execute($id)
            ]);
        }catch(DomainException $e){
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function update(int $id, Request $request){
        try{
            $data = $request->validated();
            $dto = new UpdateUserDTO(
                name: $data['name'],
                email: $data['email']
            );
            return response()->json([
                'data' => $this->updateUser->execute($id, $dto)
            ]);
        } catch(DomainException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function deleteUserById(int $id){
        try{
            $this->deleteUser->execute($id);
            return response()->json(['message' => 'Usuário deletado com sucesso.']);
        } catch(DomainException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
