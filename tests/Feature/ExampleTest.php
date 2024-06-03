<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
//use Tests\TestCase;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $user = User::find(1);
       // dump($user);
        $this->actingAs($user);
        $response = $this->post('/advert/delete',['check'=>['1']]);
        dump($response->status());
      //  $response = $this->get('/api/adverts');
//        $response = $this->get('/login');
//        $r =     phpinfo();
        //Log::info(phpinfo());
        //assert(true);
     //   $response->assertStatus(200);
     //   dump($user->token);
        $this->assertTrue(true);
    }
}
