<?php
    namespace App\Http\Services;

    use App\Repository\AuthRepository;

class AuthService
    {
        private $AuthRepository;

        public function __construct(AuthRepository $authRepository)
        {
            $this->AuthRepository = $authRepository;
        }

        public function login($email, $password)
        {
            return $this->AuthRepository->login($email, $password);
        }

        public function register($FULL_NAME,$City ,$EMAIL, $password)
        {
            return $this->AuthRepository->register($FULL_NAME, $City ,$EMAIL, $password);
        }
    }
?>
