<?php

namespace App\Http\Controllers\Auth;

use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use App\Http\Controllers\Controller;

class AuthGate extends Controller
{
    public function authenticated()
    {
        try
        {
            $user = auth()->userOrFail();
        }
        catch (UserNotDefinedException $e)
        {
            return false;
        }

        return true;
    }
}
