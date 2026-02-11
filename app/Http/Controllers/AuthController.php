<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\AuthService;

class AuthController extends Controller
{
    private $AuthService;

    public function __construct(AuthService $AuthService)
    {
        $this->AuthService = $AuthService;
    }

    public function login(Request $request) {


    $result = $this->AuthService->login($request->email, $request->password);

        if (!$result) {
            return response()->json(['message' => 'Ghalat a sahbi!'], 401);
        }

        return response()->json($result, 200);
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
