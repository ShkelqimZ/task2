<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_loan_when_book_has_available_copies(): void
    {
        $book = Book::factory()->create(['available_copies' => 3]);

        $payload = [
            'book_id' => $book->id,
            'member_id' => Member::factory()->create()->id,
            'due_at' => now()->addWeek(),
        ];

        $response = $this->postJson('/api/loans', $payload);

        $response->assertCreated()->assertJsonFragment(['book_id' => $book->id]);

        $this->assertDatabaseHas('loans', ['book_id' => $book->id]);

        $this->assertEquals(2, $book->fresh()->available_copies);
    }

    public function test_cannot_create_loan_when_no_available_copies(): void
    {
        $book = Book::factory()->create(['available_copies' => 0]);

        $payload = [
            'book_id' => $book->id,
            'member_id' => Member::factory()->create()->id,
            'due_at' => now()->addWeek(),
        ];

        $response = $this->postJson('/api/loans', $payload);

        $response->assertStatus(409);
        $response->assertJsonFragment([
            'message' => 'No available copies for this book.'
        ]);

        $this->assertDatabaseMissing('loans', ['book_id' => $book->id]);
        $this->assertEquals(0, $book->fresh()->available_copies);
    }

    public function test_user_can_return_a_book(): void
    {
        $book = Book::factory()->create(['available_copies' => 2]);

        $loan = Loan::factory()->create([
            'book_id' => $book->id,
        ]);

        $response = $this->postJson("/api/loans/{$loan->id}/return");

        $response->assertNoContent();

        $this->assertNotNull($loan->fresh()->returned_at);
        $this->assertEquals(3, $book->fresh()->available_copies);
    }

}
