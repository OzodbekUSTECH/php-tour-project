<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Day;

use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Json;
use VI\MoonShineSpatieTranslatable\Fields\Translatable;
use VI\MoonShineSpatieMediaLibrary\Fields\MediaLibrary;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Tab;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\HasMany;

use MoonShine\Fields\Relationships\BelongsTo;

class DayResource extends ModelResource
{
    protected string $model = Day::class;

    protected string $title = 'Days';

    public function fields(): array
    {
        return [
            Tabs::make([
                Tab::make('Основное', [
                    ID::make()->sortable(),
                    Number::make('День', 'day_number'),
                    Translatable::make('Название', 'title')
                        ->languages(config('app.available_languages'))
                        ->tinyMce()
                        ->removable(),
                    Translatable::make('Описание', 'description')
                        ->languages(config('app.available_languages'))
                        ->hideOnIndex()
                        ->tinyMce()
                        ->removable(),

                    BelongsTo::make('Тур', 'tour', function ($item) {
                        $cleanTitle = strip_tags($item->title);
                        return $cleanTitle;
                    })
                        ->searchable()




                ]),
                Tab::make('Изображения', [
                    MediaLibrary::make('Изображения', 'day_images')
                        ->multiple()
                        ->removable()
                ]),
            ])
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        $language = app()->currentLocale();
        return ['id', 'title->' . $language];
    }
}
