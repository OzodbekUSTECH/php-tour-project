<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Day\DayCollection;
use App\Models\Day;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class DayController extends Controller
{
    public function index($language)
    {
        app()->setLocale($language);

        $days = QueryBuilder::for(Day::class)
            ->allowedFilters(Day::filters())
            ->get();

        return new DayCollection($days);
    }
}
