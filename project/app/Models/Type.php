<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasTranslations;
use Spatie\QueryBuilder\AllowedFilter;
use App\Utils\FiltersJsonField;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Type extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'name',
        'url',
    ];

    public $translatable = ['name'];

    public static function filters()
    {
        return [
            'created_at',
            AllowedFilter::custom('name', new FiltersJsonField),
        ];
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'tours_types');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('type_image')
            ->useDisk('types')
            ->withResponsiveImages();
            // ->singleFile();
    }

}
