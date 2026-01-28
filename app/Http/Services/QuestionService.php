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
    }

?>
