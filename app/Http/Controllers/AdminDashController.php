<?php

namespace App\Http\Controllers;

use App\Models\Favoris;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashController extends Controller
{

    public function index()
    {
        return response()->json([
            'questionstot' => Question::count(),
            'reponses'  => Reponse::count(),
            'favoris' => Favoris::count(),
            'users' => User::count(),
            'questions' => Question::with(['user', 'reponses'])->latest()->get()
        ]);
    }

}
