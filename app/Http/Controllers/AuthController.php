<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\AuthService;

class AuthController extends Controller
{
    private $AuthService;

    public  function __construct(AuthService $authService)
    {
        $this->AuthService = $authService;
    }

    public function Show()
    {
        return view('home');
    }

    public  function login(){

        $email = request('email');
        $password = request('password');

        $user = $this->AuthService->login($email, $password);

        if($user) {

            return view('affichage');
        }
    }

    public function register()
    {
        $FULL_NAME = request('full_name');
        echo $FULL_NAME;
        $EMAIL = request('email');
        $password = request('password');

        if($this->AuthService->register($FULL_NAME, $EMAIL, $password)) {
            return view('home');
        }

    }

}
