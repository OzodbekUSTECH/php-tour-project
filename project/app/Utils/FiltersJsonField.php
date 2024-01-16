<?php

namespace App\Utils;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FiltersJsonField implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $locale = app()->getLocale();


        $cleanTitle = strip_tags(htmlspecialchars_decode(trim($value)));
        return $query->where("{$property}->{$locale}", 'LIKE', "%{$cleanTitle}%");
    }
}
