<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiAdvertController extends Controller
{
    public function getAll(Request $request)
    {
        $userId = $request->user('sanctum') ? $request->user('sanctum')->id : false;
        $categoryId = $request['category'];

        if ($userId) {
            $query = DB::table('adverts')
                ->leftJoin('purchases', function ($join) use ($userId) {
                    $join->on('adverts.id', '=', 'purchases.advert_id')
                        ->where('purchases.user_id', '=', $userId);
                })
                ->select(
                    'adverts.*',
                    'purchases.state as purchases_state',
                    'purchases.id as purchases_id'
                );
        } else {
            $query = DB::table('adverts');
        }

        if ($categoryId) {
            $query
                ->join('categories', 'categories.id', '=', 'adverts.category_id')
                ->where('categories.parent_id', '=', $categoryId);
        }
        return response()->json([
            'adverts' => $query->get()
        ]);
    }



}
