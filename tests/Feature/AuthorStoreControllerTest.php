<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorStoreControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_creates_author()
    {
        $data = Author::factory()->make()->toArray();

        $data['teste'] = "aaaaa";

        $response = $this->post('/authors', $data);

        $response->assertJsonStructure([
            'name',
            'genre',
            'birthdate'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('authors', [
            'name' => $data['name'],
        ]);
    }
      /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_error()
    {
        $data = [
            "name" => "aaaaa"
        ];

        $response = $this->post('/authors', $data);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('authors', [
            'name' => $data['name'],
        ]);
    }
}
