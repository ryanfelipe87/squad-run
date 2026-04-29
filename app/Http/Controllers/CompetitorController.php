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

        return response()->json([
            'data' => $competitors
        ]);
    }

    public function show(int $id)
    {
        try {
            $competitor = $this->getCompetitorById->execute($id);

            return response()->json([
                'data' => $competitor
            ]);

        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
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

            return response()->json([
                'message' => 'Competidor criado com sucesso',
                'data' => $competitor
            ], 201);

        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);

        } catch (Exception $e) {
            $idError = logErro($e->getMessage());

            return response()->json([
                'message' => 'Erro interno',
                'error_id' => $idError
            ], 500);
        }
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

            $updated = $this->updateCompetitor->execute($id, $dto);

            return response()->json([
                'message' => 'Competidor atualizado com sucesso',
                'data' => $updated
            ]);

        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);

        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'Não autorizado'
            ], 403);

        } catch (Exception $e) {
            $idError = logErro($e->getMessage());

            return response()->json([
                'message' => 'Erro interno',
                'error_id' => $idError
            ], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $competitor = $this->getCompetitorById->execute($id);

            $this->authorize('delete', $competitor);

            $this->deleteCompetitor->execute($id);

            return response()->json([
                'message' => 'Competidor deletado com sucesso'
            ]);

        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);

        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'Não autorizado'
            ], 403);

        } catch (Exception $e) {
            $idError = logErro($e->getMessage());

            return response()->json([
                'message' => 'Erro interno',
                'error_id' => $idError
            ], 500);
        }
    }

    public function myEvents()
    {
        try {
            $events = $this->getCompetitorEvents->execute(auth()->id());

            return response()->json([
                'data' => $events
            ]);

        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);

        } catch (Exception $e) {
            $idError = logErro($e->getMessage());

            return response()->json([
                'message' => 'Erro interno',
                'error_id' => $idError
            ], 500);
        }
    }
}
