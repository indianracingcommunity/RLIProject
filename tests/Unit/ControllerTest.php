<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\Controller;

class ControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testMillisToStandard()
    {
        $k = new Controller();
        $this->assertEquals($k->convertMillisToStandard(1), "00.001");
        $this->assertEquals($k->convertMillisToStandard(10), "00.010");
        $this->assertEquals($k->convertMillisToStandard(100), "00.100");
    }
}
