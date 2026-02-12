<?php

namespace App\Http\Controllers;

use App\Models\Favoris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FavorisController extends Controller
{
    public function favoris(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'question_id' => 'required|exists:questions,id',
        ]);

        $exists = \DB::table('favoris')
            ->where('user_id', $user->id)
            ->where('question_id', $request->question_id)
            ->first();

        if ($exists) {
            \DB::table('favoris')
                ->where('user_id', $user->id)
                ->where('question_id', $request->question_id)
                ->delete();
                
            return response()->json(['message' => 'Supprimé des favoris'], 200);
        }

        $addFav = \DB::table('favoris')->insert([
            'user_id' => $user->id,
            'question_id' => $request->question_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($addFav) {
            return response()->json(['message' => 'Ajouté au favoris'], 201);
        }

        return response()->json(['message' => 'Impossible d’ajouter'], 400);
    }

    public function index()
    {
        $favoris = Favoris::with([
        'user',                  
        'question.user',         
        'question.reponses.user'])->get();


        return response()->json(['favoris'=>$favoris]);
    }
}
