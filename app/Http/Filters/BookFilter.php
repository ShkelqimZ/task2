<?php

namespace App\Http\Filters;

use App\Http\Filters\QueryFilter;


class BookFilter extends QueryFilter
{
    protected function title($value): void
    {
        if (!empty(trim($value))) {
            $this->builder->where('title', 'like', '%' . $value . '%');
        }
    }

    protected function author($value): void
    {
        if (!empty(trim($value))) {
            $this->builder->where('author', 'like', '%' . $value . '%');
        }
    }

    protected function isbn($value): void
    {
        if (!empty(trim($value))) {
            $this->builder->where('isbn', 'like', '%' . $value . '%');
        }
    }
}