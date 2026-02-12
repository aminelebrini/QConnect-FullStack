<?php
    namespace App\Http\Services;


    use App\Http\Repository\QuestionRepository;

class QuestionService
    {
        private $QuestionRepository;

        public function __construct(QuestionRepository $questionRepository)
        {
            $this->QuestionRepository = $questionRepository;
        }

        public function createQuestion($titre, $description, $user_id,$city)
        {
            return $this->QuestionRepository->createQuestion($titre, $description, $user_id,$city);
        }

        public function ReigstreFavoris($question_id, $user_id)
        {
            return $this->QuestionRepository->Reigstre_Favoris($question_id, $user_id);
        }

        // public function delete($favoris_id)
        // {
        //     return $this->QuestionRepository->delete($favoris_id);
        // }
        // public function deletequestion($question_id)
        // {
        //     return $this->QuestionRepository->deletequestion($question_id);
        // }

        // public function modifier($titre, $description, $city, $question_id)
        // {
        //     return $this->QuestionRepository->modifier($titre, $description, $city, $question_id);
        // }

    }

?>
