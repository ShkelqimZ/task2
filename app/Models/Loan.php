<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = ['book_id', 'member_id', 'loaned_at', 'due_at', 'returned_at'];

    /**
     * A loan belongs to a book.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * A loan belongs to a member.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
