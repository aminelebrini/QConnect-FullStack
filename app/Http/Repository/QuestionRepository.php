<?php

    namespace App\Http\Repository;

    use App\Models\Question;

class QuestionRepository
{
    public function createQuestion($titre, $description, $user_id,$city)
    {
        $question = Question::create([
            'titre' => $titre,
            'description' => $description,
            'user_id' => $user_id,
            'city' => $city
        ]);
        $question->save();
        return $question;
    }

}

?>
