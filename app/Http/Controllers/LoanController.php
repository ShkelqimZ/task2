<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Services\LoanService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoanRequest;

/**
 * LoanController
 * @package App\Http\Controllers
 */
class LoanController extends Controller
{
    /**
     * LoanController constructor
     * @param LoanService $loanService
     */
    public function __construct(public LoanService $loanService) {}

    /**
     * Store a new loan.
     * @param LoanRequest $request
     * @return JsonResponse
     */
    public function store(LoanRequest $request): JsonResponse
    {
        $loan = $this->loanService->createLoan($request);

        return response()->json($loan, 201);
    }

    /**
     * Return a book.
     * @param Loan $loan
     * @return JsonResponse
     */
    public function returnBook(Loan $loan): JsonResponse
    {
        $this->loanService->returnBook($loan);

        return response()->json(null, 204);
    }
}
