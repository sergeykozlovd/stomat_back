<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
//use Tests\TestCase;

use App\Http\Controllers\AppConst;
use App\Models\Advert;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {


//        $t = DB::table('adverts');
//        $t = DB::table('adverts')->where('category_id',2);
//        $t = DB::table('adverts')->where('category_id',10)->first();
//        $t = DB::table('adverts')->where('category_id',2)->value('title');
//        $t = DB::table('adverts')->where('category_id',2)->find(2);
//        $t = DB::table('adverts')->where('category_id',2)->pluck('title');
//        $t = DB::table('adverts')->pluck('title','id');
//        $t = DB::table('adverts')->select('title')->get();
//        $t = DB::table('adverts')->orderBy('id')->chunk(3, function (Collection $adverts) {
//            foreach ($adverts as $advert) {
//                dump($advert->title);
//                if ($advert->id == 7) {
//                    return false;
//                }
//            }
//        });
//        $t = DB::table('adverts')->count();
//        $t = DB::table('adverts')->max('price');
//        $t = DB::table('adverts')->avg('price');
//        $t = DB::table('adverts')->min('price');
//        $t = DB::table('adverts')->sum('price');
//        $t = DB::table('adverts')->where('price','1001')->exists();
//        $t = DB::table('adverts')->where('price','1001')->doesntExist();
//        $t = DB::table('adverts')->select('price as advert_price')->get();

//        $t = DB::table('adverts')->select('price');
//        $t = $t->addSelect('title')->get();

        $section = 7;
        $categories = DB::table('categories')
        ->where('parent_id',$section)->pluck('id');

        $t = DB::table('adverts')->
            where('category_id',$section)->get();





        dump($t);
//        dump($t->toSql());
      //  dump($t->get());

        $this->assertTrue(true);
    }
}
