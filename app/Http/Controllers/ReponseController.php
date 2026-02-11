<?php

namespace App\Http\Controllers;

use App\Http\Services\ReponseService;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReponseController extends Controller
{
    private $reponseService;

    public function __construct(ReponseService $reponseService)
    {
        $this->reponseService = $reponseService;
    }

    public function Reponse(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'question_id' => 'required|exists:questions,id',
        ]);
        $user = Auth::user();
        $this->reponseService->createReponse(
            $request->content,
            $user->id,
            $request->question_id
        );

        return response()->json([
            'message' => 'Réponse ajoutée avec succès'
        ]);
    }

    public function index()
    {
        $questions = Question::with(['reponses.user', 'user'])->get();

        return view('affichage', [
            'title' => 'affichage',
            'questions' => $questions,
        ]);
    }

}
