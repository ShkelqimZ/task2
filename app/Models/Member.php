<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'email', 'membership_date'];

    /**
     * A member can have many loans.
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
