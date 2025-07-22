<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Loan Model Class
 * @package App\Models
 */
class Loan extends Model
{
    use HasFactory;
    
    protected $fillable = ['book_id', 'member_id', 'loaned_at', 'due_at', 'returned_at'];

    /**
     * A loan belongs to a book.
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * A loan belongs to a member.
     * @return BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
