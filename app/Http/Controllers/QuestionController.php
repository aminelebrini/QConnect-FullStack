<?php

namespace App\Http\Controllers;

use App\Http\Services\QuestionService;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function Question(Request $request)
    {
        $request->validate([
            'titre' => 'required|string',
            'description' => 'required|string',
            'city' => 'required|string'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Not authenticated'], 401);
        }

        $created = $this->questionService->createQuestion(
            $request->titre,
            $request->description,
            $user->id,
            $request->city
        );

        if ($created) {
            return response()->json([
                'message' => 'Question créée!',
                'data' => $created
            ], 201);
        }

        return response()->json(['message' => 'Mochkil f service'], 400);
    }

    public function index()
    {
        $questions = Question::with('user')->latest()->get();
        return response()->json(['questions' => $questions]);
    }
}
