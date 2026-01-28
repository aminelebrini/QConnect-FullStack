<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffichageController extends Controller
{
    public function index()
    {
        return view('affichage', [
            'title' => "affichage",
        ]);
    }
}
