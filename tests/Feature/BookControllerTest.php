<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It returns a paginated list of books.
     */
    public function test_it_returns_a_paginated_list_of_books(): void
    {
        Book::factory()->count(15)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'title', 'author', 'available']
                     ],
                     'links',
                     'meta',
                 ]);

        $this->assertEquals(10, count($response->json('data')));
    }
}
