<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRegisterRequest;
use App\Services\EventService;
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
        $response = $this->eventService->getAllEvents();
        return response()->json($response);
    }

    public function createEvent(EventRegisterRequest $request){
        $data = $request->validated();
        $response = $this->eventService->createEvent($data);
        return response()->json($response, 201);
    }
}
