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
        $organizations = $this->getAllOrganizations->execute();
        return view('organizations.index', compact('organizations'));
    }

    public function show(int $id)
    {
        try {
            $organization = $this->getOrganizationById->execute($id);
            return view('organizations.show', compact('organization'));
        } catch (DomainException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function create()
    {
        return view('organizations.create');
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

            $organization = $this->createOrganization->execute($dto);

            return redirect()->route('organizations.show', $organization->id)->with('success', 'Organização criada com sucesso');

        } catch (DomainException $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function edit(int $id)
    {
        $organization = $this->getOrganizationById->execute($id);
        $this->authorize('update', $organization);
        return view('organizations.edit', compact('organization'));
    }

    public function update(Request $request, int $id)
    {
        try {
            $organization = $this->getOrganizationById->execute($id);

            $this->authorize('update', $organization);

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

            $organization = $this->updateOrganization->execute($id, $dto);

            return redirect()->route('organizations.show', $organization->id)->with('success', 'Organização atualizada com sucesso');

        } catch (AuthorizationException $e) {
            return redirect()->back()->withErrors('Não autorizado');
        } catch (DomainException $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(int $id)
    {
        try {
            $org = $this->getOrganizationById->execute($id);

            $this->authorize('delete', $org);

            $this->deleteOrganization->execute($id);

            return redirect()->route('organizations.index')->with('success', 'Organização deletada com sucesso');

        } catch (AuthorizationException $e) {
            return redirect()->back()->withErrors('Não autorizado');
        } catch (DomainException $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
}
