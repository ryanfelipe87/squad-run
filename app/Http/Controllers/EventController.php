<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRegisterRequest;
use App\Models\Event;
use App\Services\EventService;
use DomainException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        } catch(AuthorizationException $e){
            return response()->json([
                'message' => 'Unauthorized to create an event.'
            ], 403);
        }catch(Exception $e){
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
        } catch(AuthorizationException $e){
            return response()->json([
                'message' => 'Unauthorized to update this event.'
            ], 403);
        }catch(Exception $e){
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
        } catch(AuthorizationException $e){
            return response()->json([
                'message' => 'Unauthorized to delete this event.'
            ], 403);
        }catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while deleting the event.',
                'error_id' => $idError
            ], 500);
        }

        return response()->json($response, 200);
    }

    public function finishEventsByOrganization(){
        try{
            $user = Auth::user();
            $organization = $user->organization;

            if(!$organization){
                return response()->json([
                    'message' => 'User is not associated with any organization.'
                ], 400);
            }

            $this->authorize('finish', Event::class);
            $this->eventService->finishEventsByOrganization($organization->id);
        }catch(AuthorizationException $e){
            return response()->json([
                'message' => 'Unauthorized to finish events.'
            ], 403);
        }catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while finishing the events.',
                'error_id' => $idError
            ], 500);
        }

        return response()->json([
            'message' => 'Events finished successfully.'
        ], 200);
    }

    public function registerResult(int $id, Request $request){
        try{
            $event = Event::findOrFail($id);
            $this->authorize('finish', $event);
            $response = $this->eventService->registerResult($event, $request->all());
        }catch(DomainException $e){
            return response()->json(['message' => $e->getMessage()], 422);
        }catch(AuthorizationException $e){
            return response()->json([
                'message' => 'Unauthorized to register result for this event.'
            ], 403);
        }catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while registering the result.',
                'error_id' => $idError
            ], 500);
        }

        return response()->json([
            'message' => 'Result registered successfully.',
            'data' => $response
        ], 200);
    }

    public function getRanking(Event $event){
        return $this->eventService->getRanking($event);
    }
}
