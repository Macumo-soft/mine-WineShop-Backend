<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Response\Handler as ResponseHandler;
use App\Validations\Handler as ValidationHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'email' => 'required|email',
                'password' => 'required',
            ];

            // Validation Check
            ValidationHandler::default($request, $rules);

            // Check if value exist
            ValidationHandler::checkArrayValueExists($request);
            // Handle authentication
            ValidationHandler::checkAuthAttempt($request);

            // Request parameters
            // $request_params = $this->requestHandler($request, $rules);

            // Get User email
            $user = User::where('email', $request->email)
                ->where('delete_flg', false)
                ->first();

            // Return error message when user doesn't exist
            if (empty($user)) {
                throw new \Exception(
                    "User not found",
                    config('response.status.bad_request.code')
                );
            };

            // Get token expiry date (request day + 1 day)
            // eg: 2022-01-01 10:00:00 -> 2022-01-02 10:00:00
            $token_expiration_date = now()->addDay();

            // Generate access token
            $access_token = $user->createToken("login:user{$user->id}", ['*'], $token_expiration_date)->plainTextToken;

            // Create response array
            $response = array(
                "token" => $access_token,
                "expiration_date" => $token_expiration_date,
            );

        } catch (\Throwable$th) {
            // Return error
            return ResponseHandler::error(
                $th->getCode(),
                $th->getMessage()
            );
        }
        
        // Return success
        return ResponseHandler::success($response);
    }

    public function logout(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'token' => 'required',
            ];

            // Validation Check
            ValidationHandler::default($request, $rules);

            // Delete user logically
            $user = User::getUserFromPlainToken($request);

        } catch (\Throwable$th) {
            // Return error
            return ResponseHandler::error(
                $th->getCode(),
                $th->getMessage()
            );
        }

        // Return success
        return ResponseHandler::success($response, "User deregistered successfully");
    }

    public function registerUser(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ];

            // Validation Check
            ValidationHandler::default($request, $rules);

            // Insert user data to database
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_user' => 'mine_backend',
                'updated_user' => 'mine_backend',
            ]);

            // Get token expiry date (request day + 1 day)
            // eg: 2022-01-01 10:00:00 -> 2022-01-02 10:00:00
            $token_expiration_date = now()->addDay();

            // Generate access token
            $access_token = $user->createToken("login:user{$user->id}", ['*'], $token_expiration_date)->plainTextToken;

            // Create response array
            $response = array(
                "token" => $access_token,
                "expiration_date" => $token_expiration_date,
            );

        } catch (\Throwable$th) {
            // Return error
            return ResponseHandler::error(
                $th->getCode(),
                $th->getMessage()
            );
        }

        // Return success
        return ResponseHandler::success($response, "User created successfully");
    }

    public function deregisterUser(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'token' => 'required',
            ];

            // Validation Check
            ValidationHandler::default($request, $rules);

            // Delete user logically
            User::deleteUser($request);

        } catch (\Throwable$th) {
            // Return error
            return ResponseHandler::error(
                $th->getCode(),
                $th->getMessage()
            );
        }

        // Return success
        return ResponseHandler::success($response, "User deregistered successfully");
    }

}
