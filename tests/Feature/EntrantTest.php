<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntrantTest extends TestCase
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

    public function testShouldSendRequestToApiEntrantsThenAddNewEntrantToDBThenReturnIdOfNewEntrant(){
        $json = [
            'name' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123456789',
            'event_id' => 1
        ];

        $response = $this->json(
            'POST',
            '/api/entrants',
            $json

        );

        $response
            ->assertStatus(201)
            ->assertExactJson(
                $json
            );
    }
}
