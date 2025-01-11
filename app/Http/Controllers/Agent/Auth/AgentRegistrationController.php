<?php

namespace App\Http\Controllers\Agent\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Google\Service\Docs\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use OpenApi\Attributes as OA;


class AgentRegistrationController extends Controller
{
    /**
     * Registers a new agent
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validate the incoming request data
        // return $request->all();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'phone_number' => 'nullable|digits:10|starts_with:0|unique:users',
            'password' => ['required', 'confirmed', 'min:8'],
        ]);


        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        // Create the agent
        $userData = $request->all();
        $userData['user_type'] = 'agent';
        $user = User::create($userData);
        Auth::login($user);
        $token = $user->createToken($request->name)->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Agent is created successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }
    /**
     * Method that handles the login of an agent.
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => ['required', 'exists:users'],
            'password' => ['required']
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'These are not valid credentials',
            ], 401);
        }
        if ($user->user_type != 'agent') {
            return response()->json([
                'message' => 'These are not valid credentials',
            ], 401);
        }

        $token = $user->createToken('apitoken')->plainTextToken;

        return response()->json([
            'agent' => $user,
            'token' => $token,
        ], 200);
    }

    /**
     * Method that handles the logout of an agent.
     *
     * @param Request $request
     * @return Response
     */

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'You are logged out',
        ], 200);
    }
    /**
     * Method to initiate the password reset process.
     *
     * @param Request $request
     * @return Response
     */

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            // Set a longer timeout just for this operation
            set_time_limit(120); // 2 minutes

            $status = Password::sendResetLink($request->only('email'));

            return $status === Password::RESET_LINK_SENT
                ? response()->json(['message' => __('Password reset link sent!')], 200)
                : response()->json(['message' => __('Failed to send reset link.')], 400);
        } catch (\Exception $e) {
            Log::error('Password reset email failed: ' . $e->getMessage());
            return response()->json([
                'message' => __('Failed to send reset link. Please try again later.')
            ], 500);
        }
    }

    /**
     * Method to reset the user's password.
     *
     * @param Request $request
     * @return Response
     */

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
            'password_confirmation' => 'required' // Add this validation
        ]);



        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __('Password reset successful!')], 200)
            : response()->json(['message' => __('Failed to reset password.')], 500);
    }
}
