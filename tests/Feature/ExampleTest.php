<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
//use Tests\TestCase;

use App\Models\User;
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
        $purchases = DB::table('purchases');

        $adverts = DB::table('adverts')
            ->join('purchases','adverts.id', '=','purchases.advert_id')
            ->select('adverts.*')
            ->distinct()
            ->get();

        dump($adverts);

        $this->assertTrue(true);
    }
}
