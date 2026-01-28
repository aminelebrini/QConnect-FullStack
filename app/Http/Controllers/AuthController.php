<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Support\Facades\Auth;

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

            Auth::login($user);
            if($user->role == 'admin'){
                return redirect()->route('admindash');
            }else
            {
                return redirect()->route('affichage');
            }
        }
    }

    public function register()
    {
        $FULL_NAME = request('full_name');
        $City = request('city');
        $EMAIL = request('email');
        $password = request('password');

        if($this->AuthService->register($FULL_NAME,$City ,$EMAIL, $password)) {
            return view('home');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect('home');
    }

}
