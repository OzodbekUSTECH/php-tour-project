<?php

namespace App\Utils;

use Illuminate\Http\Request;

class MediaHandler
{
    /**
     * Process the images array.
     *
     * @param mixed $resource
     * @param string $collection_name
     * @return array
     */
    public static function processImages(mixed $resource, string $collection_name): array
    {
        $images_lib = $resource->getMedia($collection_name);
        $processedImages = [];

        foreach ($images_lib as $image) {
            $originalDirectory = dirname($image->getFullUrl());
            $responsive_images = [];

            foreach ($image['responsive_images']['media_library_original']['urls'] as $res_image) {
                $responsive_images = array_merge($responsive_images, [
                    "$originalDirectory/responsive-images/$res_image,"
                ]);
            }

            $processedImages[] = [
                'id' => $image->id,
                'order_column' => $image->order_column,
                'original_url' => $image->getFullUrl(),
                'responsive_images' => $responsive_images,
            ];
        }

        return $processedImages;
    }

    public static function processImage(mixed $resource, string $collection_name)
    {
        $image_array = self::processImages($resource, $collection_name);

        return !empty($image_array) ? $image_array[0] : null;
    }


    public static function downloadAllMediaFromRequest(Request $request, mixed $model, string $keyName, string $media_collection)
    {
        if ($request->hasFile($keyName)) {
            $model->addAllMediaFromRequest($keyName)
                ->each(function ($image) use ($media_collection) {
                    $image->toMediaCollection($media_collection);
                });
        }
    }

    public static function downloadAllMedia(array $images, mixed $model, string $media_collection)
    {
        foreach ($images as $image) {
            $model->addMedia($image)->toMediaCollection($media_collection);
        }
    }

    public static function deleteMedia(Request $request, mixed $model, string $keyName)
    {
        if ($request[$keyName]) {
            foreach ($request[$keyName] as $mediaId) {
                $model->deleteMedia($mediaId);
            }
            $model->clearMediaCollection();
        }
    }
}
