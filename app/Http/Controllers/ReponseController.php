<?php

namespace App\Http\Controllers;

use App\Http\Services\ReponseService;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Http\Request;

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
            'message' => 'required|string',
            'question_id' => 'required|exists:questions,id',
        ]);

        $this->reponseService->createReponse(
            $request->message,
            auth()->id(),
            $request->question_id
        );

        return redirect()->route('affichage');
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
