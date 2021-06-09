<?php

namespace Tests\Unit\Services;

use App\Models\Author;
use App\Services\AuthorCreateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\QueryException;

class AuthorCreateServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_author()
    {
        $data = Author::factory()->make()->toArray();

        $service = app()->make(AuthorCreateService::class);
        $response = $service->handle($data);

        $this->assertInstanceOf(Author::class, $response);

        $this->assertDatabaseHas('authors', [
            'name' => $data['name'],
        ]);
    }

    public function test_it_returns_exception()
    {
        $this->expectException(QueryException::class);
        $service = app()->make(AuthorCreateService::class);
        $service->handle([]);
    }
}
