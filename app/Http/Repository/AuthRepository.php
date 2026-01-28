<?php

    namespace App\Http\Repository;
    use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository
    {
        public function login($email, $password)
        {
            $user = User::where('email', $email)->first();

            if ($user && Hash::check($password, $user->password)) {
                return $user;
            }
        }

        public function register($FULL_NAME,$City ,$EMAIL, $password)
        {
            $user = new User();
            $user->fullname = $FULL_NAME;
            $user->location = $City;
            $user->email = $EMAIL;
            $user->password = Hash::make($password);

            $user->save();

            return $user;
        }

    }

?>
