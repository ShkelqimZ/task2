<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * BookController
 * @package App\Http\Controllers
 */
class BookController extends Controller
{
    /**
     * Handle the incoming request.
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        return BookResource::collection(Book::paginate(10));
    }
}
