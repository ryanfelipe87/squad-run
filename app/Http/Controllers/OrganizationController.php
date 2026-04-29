<?php

namespace App\Http\Controllers;

use App\DTOs\CreateOrganizationDTO;
use App\DTOs\UpdateOrganizationDTO;
use App\Http\Requests\OrganizationRegisterRequest;
use App\UseCases\Organizations\CreateOrganization;
use App\UseCases\Organizations\DeleteOrganization;
use App\UseCases\Organizations\GetAllOrganizations;
use App\UseCases\Organizations\GetOrganizationById;
use App\UseCases\Organizations\UpdateOrganization;
use DomainException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function __construct(
        private CreateOrganization $createOrganization,
        private GetAllOrganizations $getAllOrganizations,
        private GetOrganizationById $getOrganizationById,
        private UpdateOrganization $updateOrganization,
        private DeleteOrganization $deleteOrganization
    ) {}

    public function index()
    {
        return response()->json([
            'data' => $this->getAllOrganizations->execute()
        ]);
    }

    public function show(int $id)
    {
        try {
            return response()->json([
                'data' => $this->getOrganizationById->execute($id)
            ]);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function store(OrganizationRegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $dto = new CreateOrganizationDTO(
                userId: auth()->id(),
                name: $data['name'],
                cnpj: $data['cnpj'],
                city: $data['city'],
                state: $data['state'],
                zip_code: $data['zip_code'],
                description: $data['description']
            );

            $org = $this->createOrganization->execute($dto);

            return response()->json(['data' => $org], 201);

        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $org = $this->getOrganizationById->execute($id);

            $this->authorize('update', $org);

            $dto = new UpdateOrganizationDTO(
                ...$request->only([
                    'name',
                    'cnpj',
                    'city',
                    'state',
                    'zip_code',
                    'description'
                ])
            );

            return response()->json([
                'data' => $this->updateOrganization->execute($id, $dto)
            ]);

        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Não autorizado'], 403);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function destroy(int $id)
    {
        try {
            $org = $this->getOrganizationById->execute($id);

            $this->authorize('delete', $org);

            $this->deleteOrganization->execute($id);

            return response()->json(['message' => 'Deletado com sucesso']);

        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Não autorizado'], 403);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
