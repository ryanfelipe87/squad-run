<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use App\Models\Event;
use App\Services\EnrollEventCompetitorService;
use DomainException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class EnrollEventCompetitorController extends Controller
{
    protected $enrollService;

    public function __construct(EnrollEventCompetitorService $enrollService){
        $this->enrollService = $enrollService;
    }

    public function subscribeEvent(Event $event){
        try{
            $this->authorize('subscribeEvent', $event);
            $response = $this->enrollService->subscribeEvent($event);
        }catch(DomainException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }catch(AuthorizationException $e){
            return response()->json([
                'message' => 'Unauthorized to subscribe to this event.'
            ], 403);
        }catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while enrolling in the event.',
                'error_id' => $idError
            ], 500);
        }

        return response()->json([
            'message' => 'Competitor successfully enrolled in the event.',
            'data' => $response
        ], 200);
    }
}
