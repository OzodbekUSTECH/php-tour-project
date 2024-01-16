<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Utils\FiltersJsonField;
use App\Filters\FiltersHotelsId;
use App\Http\Requests\Tour\StoreTourRequest;
use App\Utils\MediaHandler;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class Day extends Model implements HasMedia
{
    use HasFactory;


    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'day_number',
        'title',
        'description',
        'tour_id'
    ];

    public $translatable = ['title', 'description'];

    public static function filters()
    {
        return [
            'tour_id',
            'created_at',
            AllowedFilter::custom('title', new FiltersJsonField),
        ];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('day_images')
            ->useDisk('days')
            ->withResponsiveImages();
    }

    public static function createDays(Request $request, Tour $tour)
    {
        $days = $request->days;
        if ($days) {
            foreach ($days as $dayData) {
                $dayData['tour_id'] = $tour->id;

                // Используйте другое имя переменной, чтобы избежать перезаписи
                $day = Day::create($dayData);
                if (isset($dayData['images'])) {
                    $day_images = $dayData['images'];

                    // Вызов метода для обработки медиа, если массив $day_images существует
                    MediaHandler::downloadAllMedia($day_images, $day, 'day_images');
                }
            }
        }
    }

    public static function deleteDays(Request $request)
    {
        if ($request->has('delete_days_ids')) {
            Day::whereIn('id', $request->delete_days_ids)->delete();
        }
    }
}
