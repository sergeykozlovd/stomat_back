<?php

namespace App\Http\Controllers;

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

//        $query = DB::table('adverts')
//            ->leftJoin('purchases', 'adverts.id', '=', 'purchases.advert_id')
//            ->select('adverts.*', 'purchases.state as purchases_state');
        //   return dd($query->get());
        return view('purchases', [
            'adverts' => $adverts
        ])->with(['alert'=>'ok']);
    }


}
