<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompetitorRegisterRequest;
use App\Models\Competitor;
use App\Services\CompetitorService;
use DomainException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CompetitorController extends Controller
{
    protected $competitorService;

    public function __construct(CompetitorService $competitorService){
        $this->competitorService = $competitorService;
    }

    public function getCompetitorById($id){
        $response = $this->competitorService->getCompetitorById($id);
        return response()->json($response);
    }

    public function allCompetitors(){
        $response = $this->competitorService->getAllCompetitors();
        return response()->json($response);
    }

    public function createCompetitor(CompetitorRegisterRequest $request){
        $data = $request->validated();
        $response = $this->competitorService->createCompetitor($data);
        return response()->json($response, 201);
    }

    public function updateCompetitor(Request $request, $id){
        try{
            $competitor = Competitor::findOrFail($id);
            $this->authorize('update', $competitor);
            $data = $request->all();
            $response = $this->competitorService->updateCompetitor($id, $data);
        }catch(ModelNotFoundException $e){
            return response()->json(['message' => 'Competitor not found.'], 404);
        }catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while updating the competitor.',
                'error_id' => $idError
            ], 500);
        }
        
        return response()->json($response, 200);
    }

    public function deleteCompetitor($id){
        try{
            $competitor = Competitor::findOrFail($id);
            $this->authorize('delete', $competitor);
            $response = $this->competitorService->deleteCompetitor($id);
        }catch(ModelNotFoundException $e){
            return response()->json(['message' => 'Competitor not found.'], 404);
        }catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while deleting the competitor.',
                'error_id' => $idError
            ], 500);
        }
        return response()->json($response, 200);
    }

    public function getCompetitorEvents(){
        try{
            $response = $this->competitorService->myEvents();
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Events returns successfully.',
            'data' => $response
        ], 200);
    }
}
