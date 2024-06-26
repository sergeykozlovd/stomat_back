<?php

namespace App\Http\Controllers;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\RouteName;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function getLogin(){
        if (Auth::check()){
            return redirect(route(RouteName::HOME));
        } else {
            return view(AppConst::login);
        }
    }

   public function postLogin(Request $request){
       if (Auth::check()) {
           return redirect()->intended(route(RouteName::HOME));
       }


       $user = User::where('email', $request['email'])->where('panel', 1)->first();
//       $user = User::where('email', $request['email'])->first();
//       Log::debug($user->password);
//       Log::debug(Hash::check('000000',$user->password));
       if ($user && Hash::check($request['password'],$user->password)) {
           Auth::login($user);
           return redirect()->intended(route(RouteName::HOME));
       }

       return redirect('/login')->withErrors([
           'email' => 'Authentication error'
       ]);
   }



   public function logout(){
       Auth()->logout();
       return redirect(AppConst::login);

   }

    public function apiLogin(Request $request)
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

    public function apiLogout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function apiRegister(RegisterRequest $request): JsonResponse
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
            $name = $request['name'];
            $surname = $request['surname'];
            $phone = $request['phone'];
            $city = $request['city'];
            Cache::put('user:code:' . $email, $code);
            Cache::put('user:password:' . $email, $password);
            Cache::put('user:name:' . $email, $name);
            Cache::put('user:surname:' . $email, $surname);
            Cache::put('user:phone:' . $email, $phone);
            Cache::put('user:city:' . $email, $city);
            //Mail::to($email)->send(new MailMessage($code, $password)); TODO open for release

            return response()->json([
                'message' => 'code sent ' . $code,
            ]);
        }
    }

    public function apiSendRegisterCode(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $code = $request->input('code');
//        $name = $request->input('name');
//        $surname = $request->input('surname');
//        $phone = $request->input('phone');
//        $city = $request->input('city');

        $savedCode = Cache::get('user:code:' . $email);
        $savedPassword = Cache::get('user:password:' . $email);
        $savedName = Cache::get('user:name:' . $email);
        $savedSurname = Cache::get('user:surname:' . $email);
        $savedPhone = Cache::get('user:phone:' . $email);
        $savedCity = Cache::get('user:city:' . $email);
        if (!$savedCode) {
            return response()->json([
                'message' => 'code not sent to this email',
            ])->setStatusCode(403);
        } elseif ($code == $savedCode) {
            Log::info($savedSurname);
            $user = User::query()->create([
                'email' => $email,
                'password' => $savedPassword,
                'name' => $savedName,
                'surname' => $savedSurname,
                'phone' => $savedPhone,
                'city' => $savedCity,
            ]);

            $token = $user->createToken($email . ':register')->plainTextToken;
            return response()->json([
                'token' => $token,
                'email' => $email,
                'password' => $savedPassword,
                'name' => $savedName,
                'surname' => $savedSurname,
                'phone' => $savedPhone,
                'city' => $savedCity,
            ]);
        } else {
            return response()->json([
                'message' => 'error code confirm',
            ])->setStatusCode(403);
        }
    }

    public function apiSendRecoveryCode(Request $request): JsonResponse
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

    public function apiRecovery(RegisterRequest $request): JsonResponse
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
