<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\StoreHotelRequest;
use App\Http\Requests\Hotel\UpdateHotelRequest;
use App\Http\Resources\Hotel\HotelCollection;
use App\Http\Resources\Hotel\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Utils\FiltersJsonField;
use App\Utils\MediaHandler;

class HotelController extends Controller
{
    private $hotels_media = 'hotel_images';

    public function index($language)
    {
        app()->setLocale($language);

        $hotels = QueryBuilder::for(Hotel::class)
            ->allowedFilters(Hotel::filters())
            ->get();

        return new HotelCollection($hotels);
    }

    public function show($language, $id)
    {
        app()->setLocale($language);
        $hotel = Hotel::find($id);
        return new HotelResource($hotel);
    }

    #ONLY FORM-DATA
    public function store(StoreHotelRequest $request, $language)
    {
        app()->setLocale($language);
        $validated = $request->validated();


        $hotel = Hotel::create($validated);

        MediaHandler::downloadAllMediaFromRequest($request, $hotel, 'images', $this->hotels_media);

        return new HotelResource($hotel);
    }


    public function update(UpdateHotelRequest $request, $language, $id)
    {
        app()->setLocale($language);

        $validated = $request->validated();

        $hotel = Hotel::find($id);

        MediaHandler::deleteMedia($request, $hotel, 'delete_media_ids');
        MediaHandler::downloadAllMediaFromRequest($request, $hotel, 'images', $this->hotels_media);

        $hotel->update($validated);

        return new HotelResource($hotel);
    }

    public function destroy($language, Hotel $hotel)
    {
        $hotel->delete();
        return response()->noContent();
    }
}
