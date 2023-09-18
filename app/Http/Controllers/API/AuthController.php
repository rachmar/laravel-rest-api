<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

use App\Models\User;

class AuthController extends BaseController
{
    
    /**
     * The function attempts to log in a user by checking if the provided email and password match any
     * user records, and returns a JSON response with the user information and a token if successful,
     * or an error message if the credentials are invalid.
     * 
     * @param LoginRequest request The  parameter is an instance of the LoginRequest class,
     * which is used to validate and retrieve the login credentials entered by the user. It contains
     * the email and password fields.
     * 
     * @return JsonResponse a JsonResponse.
     */
    public function login(LoginRequest $request): JsonResponse
    {    
        $validated = $request->validated();
        
        if(Auth::attempt($validated)) 
        {
            $user = Auth::user();

            $response = [
                'user' => $user,
                'token' => $user->createToken('Appetiser')->accessToken,
            ];

            return $this->successResponse($response);
        } 

        return $this->errorResponse('These credentials do not match our records', 404);
    }


    /**
     * The function registers a user by creating a new user record in the database, hashing the
     * password, and returning a success response with the user and an access token.
     * 
     * @param RegisterRequest request The  parameter is an instance of the RegisterRequest
     * class. It contains the data submitted by the user during the registration process, such as the
     * user's name, email, and password.
     * 
     * @return JsonResponse a JsonResponse.
     */
    public function register(RegisterRequest $request): JsonResponse
    {   
        $validated = $request->validated();

        $user = User::create($validated);

        $response = [
            'user' => $user,
            'token' => $user->createToken('Appetiser')->accessToken,
        ];

        return $this->successResponse($response);
    }
}
