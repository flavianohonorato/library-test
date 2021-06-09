<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Author;
use App\Services\AuthorCreateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AuthorStoreControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_author()
    {
        $data = Author::factory()->make()->toArray();

        $data['teste'] = "aaaaa";

        $response = $this->post('/authors', $data);

        $response->assertJsonStructure([
            'data' => [
                'name',
                'genre',
                'birthdate'
            ],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('authors', [
            'name' => $data['name'],
        ]);
    }

    public function test_it_returns_message_error()
    {
        $data = Author::factory()->make()->toArray();

        $service = Mockery::mock(AuthorCreateService::class, function ($mock) {
            $mock->shouldReceive('handle');
        });

        $this->instance(AuthorCreateService::class, $service);

        $data['teste'] = "aaaaa";

        $response = $this->post('/authors', $data);

        $response->assertStatus(500);

        $this->assertDatabaseMissing('authors', [
            'name' => $data['name'],
        ]);
    }

    public function test_it_returns_invalid_inputs()
    {
        $data = [
            "name" => "aaaaa"
        ];

        $response = $this->post('/authors', $data);

        $response->assertStatus(400);

        $this->assertDatabaseMissing('authors', [
            'name' => $data['name'],
        ]);
    }
}
