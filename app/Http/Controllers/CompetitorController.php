<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompetitorRegisterRequest;
use App\Services\CompetitorService;
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
        return response()->json($response);
    }
}
