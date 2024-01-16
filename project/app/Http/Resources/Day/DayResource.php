<?php

namespace App\Http\Resources\Day;

use App\Utils\MediaHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $data['images'] = MediaHandler::processImages($this, 'day_images');

        return $data;
    }
}
