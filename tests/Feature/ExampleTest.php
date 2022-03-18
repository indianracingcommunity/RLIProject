<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Series;

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
        // $response = $this->get('/');

        // $response->assertStatus(200);
        $s = Series::all()->toArray();
        $this->assertEquals(count($s), 0);

        $s = factory(Series::class, 1)->create();
        $this->assertEquals(1, count(Series::all()->toArray()));
    }
}
