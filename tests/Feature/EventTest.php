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

    public function testShouldListCurrentEvents()
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

    public function testShouldAddNewEventAndReturnId()
    {
        $json = [
            'name' => 'Lorem ipsum',
            'description' => 'Lorem ipsum dolor sit amet',
            'description_in_form' => 'Lorem ipsum dolor sit amet',
            'quota' => 60,
            'start_time' => '2018-01-01 00:00:00',
            'end_time' => '2018-01-02 00:00:00'
        ];

        $response = $this->json(
            'POST',
            '/api/events',
            $json
        );

        $jsonResponse = [
            'id' => 1
        ];

        $response
            ->assertStatus(201)
            ->assertJson($jsonResponse);



    }

    public function testShouldReturnErrorWhenTryingAddWithoutName()
    {
        $json = [
            'description' => 'Lorem ipsum dolor sit amet',
            'description_in_form' => 'Lorem ipsum dolor sit amet',
            'quota' => 60,
            'start_time' => '2018-01-01 00:00:00',
            'end_time' => '2018-01-02 00:00:00'
        ];

        $response = $this->json(
            'POST',
            '/api/events',
            $json
        );

        $response->
            assertStatus(422);
    }

    public function testShouldReturnErrorWhenTryingAddWithoutStartTime()
    {
        $json = [
            'name' => 'Lorem ipsum',
            'description' => 'Lorem ipsum dolor sit amet',
            'description_in_form' => 'Lorem ipsum dolor sit amet',
            'quota' => 60,
            'end_time' => '2018-01-02 00:00:00'
        ];

        $response = $this->json(
            'POST',
            '/api/events',
            $json
        );

        $response->
        assertStatus(422);
    }

    public function testShouldReturnErrorWhenTryingAddWithoutEndTime()
    {
        $json = [
            'name' => 'Lorem ipsum',
            'description' => 'Lorem ipsum dolor sit amet',
            'description_in_form' => 'Lorem ipsum dolor sit amet',
            'quota' => 60,
            'start_time' => '2018-01-01 00:00:00'
        ];

        $response = $this->json(
            'POST',
            '/api/events',
            $json
        );

        $response->
        assertStatus(422);
    }

    public function testShouldReturnErrorWhenTryingAddWithoutQuota()
    {
        $json = [
            'name' => 'Lorem ipsum',
            'description' => 'Lorem ipsum dolor sit amet',
            'description_in_form' => 'Lorem ipsum dolor sit amet',
            'start_time' => '2018-01-01 00:00:00',
            'end_time' => '2018-01-02 00:00:00'
        ];

        $response = $this->json(
            'POST',
            '/api/events',
            $json
        );

        $response->
        assertStatus(422);
    }
}
