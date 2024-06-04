<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\Purchase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function show()
    {
        $adverts = DB::table('adverts')
            ->join('purchases','adverts.id', '=','purchases.advert_id')
            ->select('adverts.*')
            ->distinct()
            ->get();
        return view('purchases', [
            'adverts' => $adverts
        ])->with(['alert'=>'ok']);
    }

    public function apiAddPurchaseToCart(Request $request){
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

    public function apiGetPurchases(Request $request): JsonResponse
    {
        return response()->json([
            'adverts' => $request->user()->adverts()->wherePivot('state',$request->state)->get()
        ]);
    }
    public function apiChangePurchaseState(Request $request): JsonResponse
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
