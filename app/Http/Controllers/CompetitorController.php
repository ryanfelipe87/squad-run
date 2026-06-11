<?php

namespace App\Http\Controllers;

use App\DTOs\CompetitorDTO;
use App\DTOs\UpdateCompetitorDTO;
use App\Http\Requests\CompetitorRegisterRequest;
use App\UseCases\Competitors\DeleteCompetitor;
use App\UseCases\Competitors\CreateCompetitor;
use App\UseCases\Competitors\GetAllCompetitors;
use App\UseCases\Competitors\GetCompetitorById;
use App\UseCases\Competitors\UpdateCompetitor;
use App\UseCases\Competitors\GetCompetitorEvents;
use DomainException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class CompetitorController extends Controller
{
    public function __construct(
        private CreateCompetitor $createCompetitor,
        private GetAllCompetitors $getAllCompetitors,
        private GetCompetitorById $getCompetitorById,
        private UpdateCompetitor $updateCompetitor,
        private DeleteCompetitor $deleteCompetitor,
        private GetCompetitorEvents $getCompetitorEvents
    ) {}

    public function index()
    {
        $competitors = $this->getAllCompetitors->execute();
        return view('competitors.index', compact('competitors'));
    }

    public function show(int $id)
    {
        try {
            $competitor = $this->getCompetitorById->execute($id);
            return view('competitors.show', compact('competitor'));

        } catch (DomainException $e) {
            return redirect()->route('competitors.index')->withErrors($e->getMessage());
        }
    }

    public function create()
    {
        return view('competitors.create');
    }

    public function store(CompetitorRegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $dto = new CompetitorDTO(
                userId: auth()->id(),
                cpf: $data['cpf'],
                sexo: $data['sexo'],
                birth_date: $data['birth_date'],
                height: $data['height'],
                weight: $data['weight']
            );

            $competitor = $this->createCompetitor->execute($dto);

            return redirect()->route('competitors.show', $competitor->id)->with('success', 'Competidor criado com sucesso!');

        } catch (DomainException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());

        } catch (Exception $e) {
            $idError = logErro($e->getMessage());
            return redirect()->back()->withInput()->withErrors('Erro interno. Código do erro: ' . $idError);
        }
    }

    public function edit(int $id)
    {
        $competitor = $this->getCompetitorById->execute($id);
        $this->authorize('update', $competitor);
        return view('competitors.edit', compact('competitor'));
    }

    public function update(Request $request, int $id)
    {
        try {
            $competitor = $this->getCompetitorById->execute($id);

            $this->authorize('update', $competitor);

            $dto = new UpdateCompetitorDTO(
                ...$request->only([
                    'cpf',
                    'sexo',
                    'birth_date',
                    'height',
                    'weight'
                ])
            );

            $this->updateCompetitor->execute($id, $dto);

            return redirect()->route('competitors.show', $id)->with('success', 'Competidor atualizado com sucesso');

        } catch (DomainException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());

        } catch (AuthorizationException $e) {
            return redirect()->back()->withErrors('Não autorizado');

        } catch (Exception $e) {
            $idError = logErro($e->getMessage());
            return redirect()->back()->withInput()->withErrors('Erro interno. Código do erro: ' . $idError);
        }
    }

    public function destroy(int $id)
    {
        try {
            $competitor = $this->getCompetitorById->execute($id);

            $this->authorize('delete', $competitor);

            $this->deleteCompetitor->execute($id);

            return redirect()->route('competitors.index')->with('success', 'Competidor deletado com sucesso');

        } catch (DomainException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (AuthorizationException $e) {
            return redirect()->back()->withErrors('Não autorizado');
        } catch (Exception $e) {
            $idError = logErro($e->getMessage());
            return redirect()->back()->withInput()->withErrors('Erro interno. Código do erro: ' . $idError);
        }
    }

    public function myEvents()
    {
        try {
            $events = $this->getCompetitorEvents->execute(auth()->id());

            return view('competitors.events', compact('events'));

        } catch (DomainException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (AuthorizationException $e) {
            return redirect()->back()->withErrors('Não autorizado');
        } catch (Exception $e) {
            $idError = logErro($e->getMessage());
            return redirect()->back()->withInput()->withErrors('Erro interno. Código do erro: ' . $idError);
        }
    }
}
