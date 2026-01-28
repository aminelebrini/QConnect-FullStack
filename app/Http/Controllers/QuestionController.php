<?php

namespace App\Http\Controllers;

use App\Http\Services\QuestionService;
use App\Models\Question;
use Illuminate\Http\Request;
class QuestionController extends Controller
{
    private $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function Question()
    {
        $titre = request('titre');
        $description = request('description');
        $user_id = auth()->id();
        $city = request('city');

        if($this->questionService->createQuestion($titre, $description, $user_id,$city)) {
            return view('affichage');
        }
    }

    public function index()
    {
        $questions = Question::all();
        return view('affichage', [
            'title' => "affichage",
            'questions' => $questions
        ]);

    }



}
