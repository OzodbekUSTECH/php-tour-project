<?php

// app/Utils/FiltersHotelsId.php

namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FiltersHotelsId implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $value = is_array($value) ? $value : explode(',', $value);

        return $query->whereHas('hotels', function ($query) use ($value) {
            $query->whereIn('hotels.id', $value);
        });
    }
}
