<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\AuthService;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    private $AuthService;

    public function __construct(AuthService $AuthService)
    {
        $this->AuthService = $AuthService;
    }

    public function show()
    {
        return view('home');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $result = $this->AuthService->login($request->email, $request->password);

        if (!$result) {
            return response()->json(['message' => 'Ghalat a sahbi!'], 401);
        }
        $token = $result->createToken('auth_token')->plainTextToken;
        return response()->json([
            'result'=> $result,
            'token' => $token
            ], 200);
    }
    

    public function register(Request $request)
    {
        return $this->AuthService->register(
            $request->full_name,
            $request->city,
            $request->email,
            $request->password
        );
}

}
