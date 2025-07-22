<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected $builder;
    public $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Apply the filter to the builder.
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder) 
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key) && $this->request->filled($key)) {
                $this->$key($value);
            }
        }

        return $builder;
    }
}