<?php

    namespace App\Repository;
    use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository
    {
        public function login($email, $password)
        {
            $user = User::where('email', $email)->first();

            if(Hash::check($password, $user->password)){
                Auth::login($user);

                return redirect('/affichage');
            }
        }

        public function register($FULL_NAME, $EMAIL, $password)
        {
            $user = new User();
            $user->fullname = $FULL_NAME;
            $user->email = $EMAIL;
            $user->password = Hash::make($password);

            $user->save();

            return $user;
        }

    }

?>
