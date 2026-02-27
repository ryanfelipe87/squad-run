<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use App\Services\EnrollEventCompetitorService;
use DomainException;
use Exception;
use Illuminate\Http\Request;

class EnrollEventCompetitorController extends Controller
{
    protected $enrollService;

    public function __construct(EnrollEventCompetitorService $enrollService){
        $this->enrollService = $enrollService;
    }

    public function subscribeEvent(Request $request, $eventId){
        try{
            $this->authorize('subscribeEvent', Competitor::class);
            $response = $this->enrollService->subscribeEvent($eventId);
        }catch(DomainException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
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
