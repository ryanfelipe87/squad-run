<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRegisterRequest;
use App\Models\Event;
use App\Services\EventService;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService){
        $this->eventService = $eventService;
    }

    public function getEventById($id){
        $response = $this->eventService->getEventById($id);
        return response()->json($response);
    }

    public function getAllEvents(){
        $this->authorize('viewAny', Event::class);
        $response = $this->eventService->getAllEvents();
        return response()->json($response);
    }

    public function createEvent(EventRegisterRequest $request){
        try{
            $this->authorize('create', Event::class);
            $data = $request->validated();
            $response = $this->eventService->createEvent($data);
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while creating the event.',
                'error_id' => $idError
            ], 500);
        }

        return response()->json($response, 201);
    }

    public function updateEvent($id, Request $request){
        try{
            $event = Event::findOrFail($id);
            $this->authorize('update', $event);
            $response = $this->eventService->updateEvent($id, $request->all());
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while updating the event.',
                'error_id' => $idError
            ], 500);
        }

        return response()->json($response, 200);
    }

    public function deleteEvent($id){
        try{
            $event = Event::findOrFail($id);
            $this->authorize('delete', $event);
            $response = $this->eventService->deleteEvent($id);
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while deleting the event.',
                'error_id' => $idError
            ], 500);
        }

        return response()->json($response, 200);
    }
}
