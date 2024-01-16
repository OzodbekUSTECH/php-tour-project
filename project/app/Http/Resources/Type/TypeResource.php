<?php

namespace App\Http\Resources\Type;

use App\Utils\MediaHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data = parent::toArray($request);

        $data['image'] = MediaHandler::processImage($this, 'type_image');

        return $data;
    }
}
