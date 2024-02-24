<?php

namespace Tests\Controllers;

use App\User;
use Tests\TestCase;
use App\Circuit;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CircuitsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testIndex()
    {
        $circuits = factory(Circuit::class, 2)->create([
            'series' => 2
        ]);

        // Mock API authentication
        // $user = factory(User::class)->create(['id' => 2]);
        // Auth::shouldReceive('guard')->once()->with('api')->andReturnSelf();
        // Auth::shouldReceive('user')->once()->andReturn($user);

        $this->json('GET', 'api/circuits?series=1&fields=id')
             ->assertStatus(Response::HTTP_OK)
             ->assertJsonCount(2)
             ->assertExactJson([
                [
                    'id' => $circuits[0]['id']
                ],
                [
                    'id' => $circuits[1]['id']
                ],
             ]);

        $this->json('GET', 'api/circuits?series=2')
             ->assertStatus(Response::HTTP_OK)
             ->assertJsonCount(0);
    }
}
