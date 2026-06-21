<?php

namespace App\Http\Controllers;

use App\UseCases\Home\HomePage;

class HomeController extends Controller
{
    public function __construct(private HomePage $homePage){}

    public function index()
    {
        $dados = $this->homePage->execute();
        return view('home', compact('dados'));
    }
}
