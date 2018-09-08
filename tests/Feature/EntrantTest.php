<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntrantTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        factory(\App\Event::class)->create();
    }

    public function testShouldSendRequestToApiEntrantsThenAddNewEntrantToDBThenReturnIdOfNewEntrant()
    {


        $json = [
            'name' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123456789',
            'event_id' => 1
        ];

        $jsonResponse = [
            'id' => 1
        ];

        $response = $this->json(
            'POST',
            '/api/entrants',
            $json

        );

        $response
            ->assertStatus(201)
            ->assertJson($jsonResponse);
    }

    public function testShouldReturnErrorWhenTryingAddNotUniqueEntrant()
    {


        factory(\App\Entrant::class)->create([
            'phone' => '123456789',
            'event_id' => 1
        ]);

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
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "phone" => [
                        "You are already registered to this event"
                    ]
                ]
            ]);
    }

    public function testShouldReturnErrorWhenNameIsNotFilled()
    {
        $json = [
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
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => [
                        "The name field is required."
                    ]
                ]
            ]);
    }

    public function testShouldReturnErrorWhenSurnameIsNotFilled()
    {
        $json = [
            'name' => 'Kowalski',
            'phone' => '123456789',
            'event_id' => 1
        ];

        $response = $this->json(
            'POST',
            '/api/entrants',
            $json

        );

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "surname" => [
                        "The surname field is required."
                    ]
                ]
            ]);
    }

    public function testShouldReturnErrorWhenPhoneIsNotFilled()
    {
        $json = [
            'name' => 'Kowalski',
            'surname' => 'Kowalski',
            'event_id' => 1
        ];

        $response = $this->json(
            'POST',
            '/api/entrants',
            $json

        );

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "phone" => [
                        "The phone field is required."
                    ]
                ]
            ]);
    }

    public function testShouldReturnErrorWhenPhoneIsLongerThan9Chars()
    {
        $json = [
            'name' => 'Kowalski',
            'surname' => 'Kowalski',
            'phone' => '123456789012345',
            'event_id' => 1
        ];

        $response = $this->json(
            'POST',
            '/api/entrants',
            $json

        );

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "phone" => [
                        "The phone may not be greater than 9 characters."
                    ]
                ]
            ]);
    }

    public function testShouldReturnErrorWhenEventIdIsNotFilled()
    {
        $json = [
            'name' => 'Kowalski',
            'surname' => 'Kowalski',
            'phone' => '123456789',
        ];

        $response = $this->json(
            'POST',
            '/api/entrants',
            $json

        );

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "event_id" => [
                        "The event id field is required."
                    ]
                ]
            ]);
    }

    public function testShouldReturnErrorWhenEventIdDoesNotExist()
    {
        $json = [
            'name' => 'Kowalski',
            'surname' => 'Kowalski',
            'phone' => '123456789',
            'event_id' => 10
        ];

        $response = $this->json(
            'POST',
            '/api/entrants',
            $json

        );

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "event_id" => [
                        "Event does not exist"
                    ]
                ]
            ]);
    }

    public function testShouldReturnErrorWhenEntrantTriesToSignToEventOverQuota()
    {
        factory(\App\Event::class)->create([
            'id' => 100,
            'quota' => 1
        ]);

        factory(\App\Entrant::class)->create([
            'event_id' => 100
        ]);

        $json = [
            'name' => 'Kowalski',
            'surname' => 'Kowalski',
            'phone' => '123456789',
            'event_id' => 100
        ];

        $response = $this->json(
            'POST',
            '/api/entrants',
            $json

        );

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "event_id" => [
                        "Event over quota."
                    ]
                ]
            ]);
    }
}
