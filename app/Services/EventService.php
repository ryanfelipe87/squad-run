<?php
namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

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
            'route_description' => $data['route_description']
        ]);

        return [
            'message' => 'Event created successfully.',
            'data' => $data->toArray()
        ];
    }
}
