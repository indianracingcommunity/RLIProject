<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use App\Series;
use App\User;
use App\Role;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInsertSeries()
    {
        // $this->assertTrue(true);
        $response = $this->get('/joinus');
        $response->assertOk();
        $response->assertViewHas('irc_guild');
        // $response->assertSee(config('services.discord.irc_guild'));

        $s = Series::all()->toArray();
        $this->assertEquals(count($s), 0);

        $s = factory(Series::class, 1)->create();
        $this->assertEquals(1, count(Series::all()->toArray()));
    }

    public function testUserProfile()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)
                         ->withSession(['userRoles' => [
                            'coordinator' => 0,
                            'signup' => 1
                         ]])
                         ->get('/home/admin/view-signups');

        $response->assertOk();
        $response->assertSee($user->name);
    }
}
