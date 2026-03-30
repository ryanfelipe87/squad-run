<?php
namespace App\Services;

use App\Enums\RegistrationStatusEnum;
use App\Models\Event;
use App\Enums\StatusEventsEnum;
use App\Jobs\UpdateCompetitorStatusJob;
use DomainException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventService {

    public function getEventById(int $id) : array{
        $event = Event::find($id);
        $message = $event ? 'Event found successfully.' : 'Event not found.';
        return [
            'message' => $message,
            'data' => $event ? $event->toArray() : null
        ];
    }

    public function getAllEvents() : array {
        $events = Event::orderBy('id')->get();
        return $events->toArray();
    }

    public function createEvent(array $data) : array {
        $user = Auth::user();

        $organization = $user->organization;

        if(!$organization)
            throw new \Exception('User is not associated with any organization.');

        $data = Event::create([
            'id_organization' => $organization->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'event_date' => $data['event_date'],
            'vacancies' => $data['vacancies'],
            'route_km' => $data['route_km'],
            'route_description' => $data['route_description'],
            'status' => StatusEventsEnum::PUBLISHED
        ]);

        return [
            'message' => 'Event created successfully.',
            'data' => $data->toArray()
        ];
    }

    public function updateEvent(int $id, array $data) : array {
        $event = Event::find($id);

        if(!$event)
            throw new \Exception('Event not found with id: ' . $id);

        $event->update($data);

        return [
            'message' => 'Event updated successfully.',
            'data' => $event->toArray()
        ];
    }

    public function deleteEvent(int $id) : array {
        $event = Event::find($id);

        if(!$event)
            throw new \Exception('Event not found with id: ' . $id);

        $event->delete();

        return [
            'message' => 'Event deleted successfully.'
        ];
    }

    public function finishEventsByOrganization(int $idOrganization) : void {
        $events = Event::with('organization')
            ->where('id_organization', $idOrganization)
            ->where('status', StatusEventsEnum::CLOSED)
            ->get();

        foreach($events as $event) {
            DB::transaction(function() use($event){
                $this->finishEvent($event);
            });
        }
    }

    public function finishEvent(Event $event) : void {
        $event = Event::with('organization')
            ->where('id', $event->id)
            ->lockForUpdate()
            ->first();
        
        if($event->status !== StatusEventsEnum::CLOSED) {
            throw new \Exception('Event must be closed before finishing.');
        }

        if($event->organization->id_user != Auth::id()) throw new AuthorizationException('Unauthorized to finish this event.');

        $hasPendingResults = $event->registrations()->where('status', '!=', RegistrationStatusEnum::FINISHED)->exists();

        if($hasPendingResults) throw new DomainException('There are still competitor without results.');

        $event->update([
            'status' => StatusEventsEnum::FINISHED
        ]);
    }

    public function registerResult(Event $event, array $dados) : void {
        if($event->status !== StatusEventsEnum::CLOSED){
            throw new DomainException('Event is not ready for results.');
        }

        $registration = $event->registrations()->where('id_competitor', $dados['id_competitor'])->lockForUpdate()->firstOrFail();

        if($registration->status === RegistrationStatusEnum::FINISHED){
            throw new DomainException('Result already registered.');
        }

        $registration->update([
            'total_time' => $dados['total_time'],
            'traveled_km' => $dados['traveled_km'],
            'position' => $dados['position'],
            'status' => RegistrationStatusEnum::FINISHED
        ]);

        UpdateCompetitorStatusJob::dispatch($dados['id_competitor'], $event->id);
    }

    public function getRanking(Event $event) : array {
        return $event->registrations()
            ->with('competitor.user')
            ->whereNotNull('total_time')
            ->orderBy('total_time')
            ->get();
    }
}
