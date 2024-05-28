<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\RouteName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}
