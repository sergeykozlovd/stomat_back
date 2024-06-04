<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function show()
    {
        $query = DB::table('adverts')
            ->leftJoin('purchases', 'adverts.id', '=', 'purchases.advert_id')
            ->select('adverts.*', 'purchases.state as purchases_state');
        //   return dd($query->get());
        return view('adverts', [
            'adverts' => $query->get()
        ])->with(['alert'=>'ok']);
    }


}
