<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Spatie\QueryBuilder\AllowedFilter;
use App\Utils\FiltersJsonField;
class Hotel extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'rating',
        'user_id'
    ];
    public $translatable = ['title', 'description'];

    public static function filters()
    {
        return [
            'created_at',
            'user_id',
            'rating',
            AllowedFilter::custom('title', new FiltersJsonField)
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'tours_hotels')->withTimestamps();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('hotel_images')
            ->useDisk('hotels')
            ->withResponsiveImages();
    }
}
