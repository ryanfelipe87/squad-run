<?php

namespace App\Http\Controllers;

use App\UseCases\Competitors\GetCompetitorDashboard;
use Exception;
use Illuminate\Http\Request;

class CompetitorDashboardController extends Controller
{
    public function __construct(
        private GetCompetitorDashboard $getCompetitorDashboard
    ){}

    public function competitorDashboard()
    {
        try
        {
            $dashboard = $this->getCompetitorDashboard->execute(auth()->id());

            return view('competitors.dashboard', compact('dashboard'));
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return redirect()->back()->withErrors('Erro interno. Código: '.$idError);
        }
    }
}
