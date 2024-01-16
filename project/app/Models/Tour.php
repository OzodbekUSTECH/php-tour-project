<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Utils\FiltersJsonField;
use App\Filters\FiltersHotelsId;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\QueryBuilder\AllowedFilter;
class Tour extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'url',
        'description',
        'user_id',
        'price',
    ];
    public $translatable = ['title', 'description'];

    public static function filters()
    {
        return [
            'created_at',
            AllowedFilter::custom('title', new FiltersJsonField),
            AllowedFilter::custom('hotels_id', new FiltersHotelsId),

        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class, 'tours_hotels')->withTimestamps();
    }

    public function days(): HasMany
    {
        return $this->hasMany(Day::class);
    }

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class, 'tours_types')->withTimestamps();
    }


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('tour_images')
            ->useDisk('tours')
            ->withResponsiveImages();
    }
}
