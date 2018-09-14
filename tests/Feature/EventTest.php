<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testShouldListCurrentShows()
    {
        factory(\App\Event::class)->create([
            'start_time' => Carbon::now()->addWeeks(1),
            'end_time' => Carbon::now()->addWeeks(2)
        ]);

        factory(\App\Event::class)->create([
            'start_time' => Carbon::now()->subWeeks(1),
            'end_time' => Carbon::now()->addWeeks(1)
        ]);

        factory(\App\Event::class)->create([
            'start_time' => Carbon::now()->subWeeks(2),
            'end_time' => Carbon::now()->subWeeks(1)
        ]);

        $response = $this->json(
            'GET',
            '/api/events'
        );

        $this->assertEquals(count(json_decode($response->content())),3);
    }
}
