<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\MailMessage;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ApiAuthController extends Controller
{

    public function login(Request $request)
    {
        $email = $request['email'];
        $user = User::where('email', $email)->first();
        if ($user !== null) {
            if (password_verify($request['password'], $user->password)) {

                $user->tokens()->delete();
                $token = $user->createToken($email . ':login')->plainTextToken;
                return response()->json([
                    'token' => $token,
                ]);
            }
        }
        return response()->json([
            'message' => 'login or password not correct'
        ])->setStatusCode(403);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $email = $validated['email'];
        $userExist = User::where('email', $email)->first();
        if ($userExist) {
            return response()->json([
                'message' => 'email exist'
            ])->setStatusCode(403);
        } else {
            $code = rand(1000, 9999);
            $password = $validated['password'];
            Cache::put('user:code:' . $email, $code);
            Cache::put('user:password:' . $email, $password);
            //Mail::to($email)->send(new MailMessage($code, $password)); TODO open for release

            return response()->json([
                'message' => 'code sent ' . $code,
            ]);
        }
    }

    public function sendRegisterCode(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $code = $request->input('code');

        $savedCode = Cache::get('user:code:' . $email);
        $savedPassword = Cache::get('user:password:' . $email);
        if (!$savedCode) {
            return response()->json([
                'message' => 'code not sent to this email',
            ])->setStatusCode(403);
        } elseif ($code == $savedCode) {

            $user = User::query()->create([
                'email' => $email,
                'password' => $savedPassword,
            ]);

            $token = $user->createToken($email . ':register')->plainTextToken;
            return response()->json([
                'token' => $token,
                'email' => $email,
                'password' => $savedPassword,
            ]);
        } else {
            return response()->json([
                'message' => 'error code confirm',
            ])->setStatusCode(403);
        }
    }

    public function sendRecoveryCode(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $code = $request->input('code');

        $savedCode = Cache::get('user:code:' . $email);
        $savedPassword = Cache::get('user:password:' . $email);

        if (!$savedCode) {
            return response()->json([
                'message' => 'code not sent to this email',
            ])->setStatusCode(403);
        } elseif ($code == $savedCode) {

            $user = User::where('email', $email)->first();
            $user->password = Hash::make($savedPassword);
            $token = $user->createToken($email . ':register')->plainTextToken;
            $user->save();

            return response()->json([
                'message' => 'Password recovery success!',
                'token' => $token,
                'email' => $email,
                'password' => $savedPassword,
            ]);
        } else {
            return response()->json([
                'message' => 'error code confirm',
            ])->setStatusCode(403);
        }
    }

    public function recovery(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $email = $validated['email'];
        $userExist = User::where('email', $email)->first();
        if (!$userExist) {
            return response()->json([
                'message' => 'email not exist'
            ])->setStatusCode(403);
        } else {
            $code = rand(1000, 9999);
            $password = $validated['password'];
            Cache::put('user:code:' . $email, $code);
            Cache::put('user:password:' . $email, $password);

          //  Mail::to($email)->send(new MailMessage($code, $password)); TODO open for release
            return response()->json([
                'message' => 'code sent ' . $code,
            ]);
        }
    }
}
