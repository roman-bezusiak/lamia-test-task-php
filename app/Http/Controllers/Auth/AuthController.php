<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * If user is registered in database, one will belogged in ind receive
     * a JWT token after providing email and password information
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Invalidated current user's logged in JWT token
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Registers user in Postgres with email and password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'email', 'unique:user'],
            'password' => ['required', 'min:12']
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'email'    => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user'    => $user
        ]);
    }

    /**
     * Returns current authenticated user info
     *
     * @return \Illuminate\Http\Response
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Renewes user's JWT token and sends the new one back to client
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Composes a JSON response with JWT data
     *
     * @return \Illuminate\Http\Response
     */
    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 3600 // Intentionally big
        ]);
    }
}
