<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Filters\BookFilter;
/**
 * BookController
 * @package App\Http\Controllers
 */
class BookController extends Controller
{
    /**
     * Handle the incoming request.
     * @param BookFilter $filters
     * @return AnonymousResourceCollection
     */
    public function __invoke(BookFilter $filters): AnonymousResourceCollection
    {
        $books = Book::filter($filters)->paginate(10);
        return BookResource::collection($books);
    }
}
