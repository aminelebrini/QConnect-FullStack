<?php

namespace App\Http\Repository;
use App\Models\Reponse;

class ReponseRepository
    {
        public function create_Reponse($message, $user_id,$question_id)
        {
            $reponse = Reponse::create([
                'content' => $message,
                'user_id' => $user_id,
                'question_id' => $question_id
            ]);

            $reponse->save();
            return $reponse;
        }
    }


?>
