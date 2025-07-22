<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Book;
use App\Models\Loan;
use App\Http\Requests\LoanRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

/**
 * Loan Service Class
 * @package App\Services
 */
class LoanService
{
    /**
     * Create a new loan.
     * @param LoanRequest $request
     * @return Loan
     */
    public function createLoan(LoanRequest $request): Loan
    {
        return DB::transaction(function () use ($request) {
            $updated = Book::where('id', $request->book_id)
                ->where('available_copies', '>', 0)
                ->decrement('available_copies');

            if (!$updated) {
                throw new ConflictHttpException('No available copies for this book.');
            }

            return Loan::create($request->validated());
        });
    }

    /**
     * Return a book.
     * @param Loan $loan
     * @return void
     */
    public function returnBook(Loan $loan): void
    {
        if ($loan->returned_at) {
            throw new \Exception('Book already returned');
        }
        $loan->returned_at = now();
        $loan->save();

        $loan->book->available_copies++;
        $loan->book->save();
    }
}