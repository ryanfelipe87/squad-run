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
        $events = $this->getAllEvents->execute();
        return view('events.index', compact('events'));
    }

    public function show(int $id)
    {
        try {
            $event = $this->getEventById->execute($id);
            return view('events.show', compact('event'));
        } catch (DomainException $e) {
            return redirect()->route('events.index')->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        $this->authorize('create', \App\Models\Event::class);
        return view('events.create');
    }

    public function store(EventRegisterRequest $request)
    {
        try {
            $this->authorize('create', \App\Models\Event::class);

            $data = $request->validated();

            $dto = new CreateEventDTO(
                userId: auth()->id(),
                title: $data['title'],
                description: $data['description'],
                event_date: $data['event_date'],
                vacancies: $data['vacancies'],
                route_km: $data['route_km'],
                route_description: $data['route_description'],
                status: $data['status']
            );

            $event = $this->createEvent->execute($dto);

            return redirect()->route('events.show', $event->id)->with('success', 'Evento criado com sucesso');

        } catch (AuthorizationException $e) {
            return redirect()->back()->withErrors('Não autorizado');
        } catch (Exception $e) {
            $idError = logErro($e->getMessage());
            return redirect()->back()->with('error', 'Erro interno. Código de erro: ' . $idError);
        }
    }

    public function edit(int $id)
    {
        $event = $this->getEventById->execute($id);
        $this->authorize('update', $event);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, int $id)
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

            $this->updateEvent->execute($id, $dto);

            return redirect()->route('events.show', $id)->with('success', 'Evento atualizado com sucesso!');

        } catch (AuthorizationException $e) {
            return redirect()->back()->withErrors('Não autorizado');
        } catch (DomainException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $event = $this->getEventById->execute($id);

            $this->authorize('delete', $event);

            $this->deleteEvent->execute($id);

            return redirect()->route('events.index')->with('success', 'Evento deletado com sucesso!');

        } catch (AuthorizationException $e) {
            return redirect()->back()->withErrors('Não autorizado');
        } catch (DomainException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function finish(int $id)
    {
        try {
            $this->finishEvent->execute($id, auth()->id());

            return redirect()->route('events.show', $id)->with('success', 'Evento finalizado com sucesso!');

        } catch (AuthorizationException $e) {
            return redirect()->back()->withErrors('Não autorizado');
        } catch (DomainException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function finishAll()
    {
        try {
            $organization = auth()->user()->organization;

            if (!$organization) {
                return redirect()->back()->withErrors('Usuário não pertence a nenhuma organização');
            }

            $this->finishEventsByOrganization->execute(
                $organization->id,
                auth()->id()
            );

            return redirect()->route('events.index')->with('success', 'Todos os eventos da organização finalizados com sucesso!');

        } catch (Exception $e) {
            $idError = logErro($e->getMessage());
            return redirect()->back()->withErrors('Erro interno. Código de erro: ' . $idError);
        }
    }

    public function registerResult(int $id, Request $request)
    {
        try {
            $dto = new RegisterResultDTO(
                eventId: $id,
                competitorId: $request->id_competitor,
                total_time: $request->total_time,
                traveled_km: $request->traveled_km,
                position: $request->position
            );

            $this->registerResult->execute($dto);

            return redirect()->route('events.ranking', $id)->with('success', 'Resultado registrado com sucesso!');

        } catch (DomainException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function ranking(int $id)
    {
        $ranking = $this->getRanking->execute($id);
        return view('events.ranking', compact('ranking'));
    }
}
