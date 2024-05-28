<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{

    public function user(Request $request): JsonResponse {

//        return response()->json([
//            'message' => 'ok',
//        ]);
        $user = $request->user();
//        Log::info($user->currentAccessToken());
//        $user->token = $user->currentAccessToken();

        return response()->json(
            $user
        );
    }

}
