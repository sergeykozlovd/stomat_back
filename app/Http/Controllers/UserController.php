<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{

    public function user(Request $request): JsonResponse {
        $user = $request->user();
        return response()->json([
            'user' => $user
        ]);
    }

    public function change_user(Request $request): JsonResponse {
       $user = $request->user();
//        Log::info($request->all());
        $user->fill($request->all());
        $user->save();
        return response()->json([
            'user' => $user
        ]);
    }
}
