<?php

namespace App\Http\Controllers;

use App\DTOs\CreateEventDTO;
use App\DTOs\UpdateEventDTO;
use App\DTOs\RegisterResultDTO;
use App\Http\Requests\EventRegisterRequest;
use App\UseCases\Events\CreateEvent;
use App\UseCases\Events\GetAllEvents;
use App\UseCases\Events\GetEventById;
use App\UseCases\Events\UpdateEvent;
use App\UseCases\Events\DeleteEvent;
use App\UseCases\Events\FinishEvent;
use App\UseCases\Events\FinishEventsByOrganization;
use App\UseCases\Events\RegisterResult;
use App\UseCases\Events\GetRanking;
use DomainException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        private CreateEvent $createEvent,
        private GetAllEvents $getAllEvents,
        private GetEventById $getEventById,
        private UpdateEvent $updateEvent,
        private DeleteEvent $deleteEvent,
        private FinishEvent $finishEvent,
        private FinishEventsByOrganization $finishEventsByOrganization,
        private RegisterResult $registerResult,
        private GetRanking $getRanking
    ) {}

    public function index()
    {
        return response()->json([
            'data' => $this->getAllEvents->execute()
        ]);
    }

    public function show($id)
    {
        try {
            return response()->json([
                'data' => $this->getEventById->execute($id)
            ]);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function store(EventRegisterRequest $request)
    {
        try {
            $this->authorize('create', \App\Models\Event::class);

            $dto = new CreateEventDTO(
                ...$request->only([
                    'title',
                    'description',
                    'event_date',
                    'vacancies',
                    'route_km',
                    'route_description'
                ])
            );

            $event = $this->createEvent->execute($dto);

            return response()->json(['data' => $event], 201);

        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Não autorizado'], 403);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $event = $this->getEventById->execute($id);

            $this->authorize('update', $event);

            $dto = new UpdateEventDTO(
                ...$request->only([
                    'title',
                    'description',
                    'event_date',
                    'vacancies',
                    'route_km',
                    'route_description',
                    'status'
                ])
            );

            return response()->json([
                'data' => $this->updateEvent->execute($id, $dto)
            ]);

        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Não autorizado'], 403);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $event = $this->getEventById->execute($id);

            $this->authorize('delete', $event);

            $this->deleteEvent->execute($id);

            return response()->json(['message' => 'Deletado com sucesso']);

        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Não autorizado'], 403);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function finish($id)
    {
        try {
            $this->finishEvent->execute($id, auth()->id());

            return response()->json(['message' => 'Evento finalizado']);

        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Não autorizado'], 403);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function finishAll()
    {
        try {
            $organization = auth()->user()->organization;

            if (!$organization) {
                return response()->json(['message' => 'Sem organização'], 400);
            }

            $this->finishEventsByOrganization->execute(
                $organization->id,
                auth()->id()
            );

            return response()->json(['message' => 'Eventos finalizados']);

        } catch (Exception $e) {
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function registerResult($id, Request $request)
    {
        try {
            $dto = new RegisterResultDTO(
                eventId: $id,
                competitorId: $request->id_competitor,
                total_time: $request->total_time,
                traveled_km: $request->traveled_km,
                position: $request->position
            );

            $result = $this->registerResult->execute($dto);

            return response()->json(['data' => $result]);

        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function ranking($id)
    {
        return response()->json([
            'data' => $this->getRanking->execute($id)
        ]);
    }
}
