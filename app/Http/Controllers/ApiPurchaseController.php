<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiPurchaseController extends Controller
{
    public function addPurchaseToCart(Request $request){
        $advert = Advert::find($request->id);
        if ($advert ){
            $userId = Auth::id();
            $advertId = $request->id;
            $count = $request->count;
            $purchaseExist = Purchase::where('user_id', $userId)->where('advert_id', $advertId)->first();
            if ($purchaseExist){
                return response()->json([
                    'message' => 'already in cart'
                ]);
            } else {
                $purchase = new Purchase();
                $purchase->user_id = $userId;
                $purchase->advert_id = $advertId;
                $purchase->count = $count;
                $purchase->state = 0;
                $purchase->save();

                return response()->json([
                    'purchases' => Purchase::where('state',0)->where('user_id',$userId)->get()
                ]);

            }
        } else {
            return response()->json([
                'message' => 'advert not exist'
            ]);
        }
    }

    public function getPurchases(Request $request): JsonResponse
    {
        return response()->json([
                'adverts' => $request->user()->adverts()->wherePivot('state',$request->state)->get()
            ]);
    }
    public function changePurchaseState(Request $request): JsonResponse
    {
        $state = $request->state;
        $advert_id = $request->advert_id;
        $user_id = Auth::id();

        $purchase = Purchase::where('advert_id',$advert_id)
            ->where('user_id',$user_id)
            ->first();

        if ($state){
            $purchase->state = $state;
        } else {
            $purchase->delete();
        }

        return response()->json([
                'adverts' => $request->user()->adverts()->wherePivot('state',$request->state)->get()
            ]);
    }
}
