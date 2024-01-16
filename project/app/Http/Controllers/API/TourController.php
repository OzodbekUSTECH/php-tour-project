<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tour\TourCollection;
use App\Http\Resources\Tour\TourResource;
use App\Http\Requests\Tour\StoreTourRequest;
use App\Http\Requests\Tour\UpdateTourRequest;
use App\Models\Day;
use App\Models\Hotel;
use App\Models\Tour;
use App\Utils\FiltersJsonField;
use App\Utils\MediaHandler;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;


class TourController extends Controller
{
    private $tours_media = 'tour_images';

    public function index($language)
    {

        app()->setLocale($language);

        $tours = QueryBuilder::for(Tour::class)
            ->allowedFilters(Tour::filters())
            ->get();

        return new TourCollection($tours);
    }

    public function show($language, $id)
    {
        app()->setLocale($language);
        $tour = Tour::find($id);
        return new TourResource($tour);
    }

    // SEND ONLY FORM-DATA WITH IMAGES!!!
    public function store(StoreTourRequest $request, $language)
    {
        app()->setLocale($language);

        $validated = $request->validated();
        $tour = Tour::create($validated);


        $tour_images = $validated['images'];
        MediaHandler::downloadAllMedia($tour_images, $tour, $this->tours_media);



        if ($request->hotels_id) {
            $tour->hotels()->attach($validated['hotels_id']);
        }
        if ($request->types_id) {
            $tour->types()->attach($validated['types_id']);
        }


        Day::createDays($request, $tour);

        return new TourResource($tour);
    }

    // SEND ONLY FORM-DATA!!!
    public function update(UpdateTourRequest $request, $language, $id)
    {

        app()->setLocale($language);
        $validated = $request->validated();

        $tour = Tour::find($id);

        MediaHandler::deleteMedia($request, $tour, 'delete_media_ids'); #delete tour media

        MediaHandler::downloadAllMediaFromRequest($request, $tour, 'images', $this->tours_media);

        if ($request->hotels_id) {
            $tour->hotels()->sync($validated['hotels_id']);
        }
        if ($request->types_id) {
            $tour->types()->sync($validated['types_id']);
        }



        Day::deleteDays($request);
        Day::createDays($request, $tour);

        $tour->update($validated);


        return new TourResource($tour);
    }

    public function destroy($language, Tour $tour)
    {
        $tour->delete();
        return response()->noContent();
    }
}
