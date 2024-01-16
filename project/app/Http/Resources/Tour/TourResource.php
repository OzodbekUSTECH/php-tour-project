<?php

namespace App\Http\Resources\Tour;

use App\Traits\ConverterCurrency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Utils\MediaHandler;
class TourResource extends JsonResource
{
    // use ConverterCurrency;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);


        $data['images'] = MediaHandler::processImages($this, 'tour_images');
        $data['hotels_id'] = $this->hotels->pluck('id');
        $data['types_id'] = $this->types->pluck('id');


        $targetCurrency = $request->get('currency', null);

        $data['price'] = ConverterCurrency::convertCurrency($this->price, $targetCurrency);

        return $data;
    }
}
