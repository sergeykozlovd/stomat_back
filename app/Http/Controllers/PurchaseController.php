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
        $purchases = DB::table('purchases')
            ->join('adverts','adverts.id', '=','purchases.advert_id')
            ->join('users','users.id', '=','purchases.user_id')
            ->select('purchases.id','users.email','adverts.title','purchases.count','purchases.state')
            ->distinct()
            ->get();

        return view('purchases', [
            'purchases' => $purchases
        ]);
    }

    public function delete(Request $request)
    {
        $alertResult = true;
        $alertTitle = 'Внимание!';
        $alertText = 'Выбранные покупки успешно удалены';
        $selectedItems = $request->input('check', []);
        if (count($selectedItems) < 1) {
            $alertResult = false;
            $alertTitle = 'Внимание!';
            $alertText = 'Покупки не выбраны!';
        } else {
            Purchase::whereIn('id', $selectedItems)->delete();
        }

        return redirect()->back()->with(
            'alert',[
            'success' => $alertResult,
            'title' => $alertTitle,
            'text' => $alertText,
        ]);
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
