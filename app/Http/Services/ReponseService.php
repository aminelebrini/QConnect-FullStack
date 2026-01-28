<?php

namespace App\Http\Services;

use App\Http\Repository\ReponseRepository;
class ReponseService
{
    private $reponseRepository;

    public function __construct(ReponseRepository $reponseRepository)
    {
        $this->reponseRepository = $reponseRepository;
    }

    public function createReponse($message, $user_id, $question_id)
    {
        return $this->reponseRepository->create_Reponse($message,$user_id, $question_id);
    }
}
