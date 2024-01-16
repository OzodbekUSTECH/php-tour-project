<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;

use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Json;
use MoonShine\Fields\Number;
use VI\MoonShineSpatieTranslatable\Fields\Translatable;
use VI\MoonShineSpatieMediaLibrary\Fields\MediaLibrary;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Tab;

use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\BelongsToMany;

class HotelResource extends ModelResource
{
    protected string $model = Hotel::class;

    protected string $title = 'Hotels';

    public function fields(): array
    {
        return [
            Tabs::make([
                Tab::make('Основное', [
                    ID::make()->sortable(),
                    Translatable::make('Название', 'title')
                        ->languages(config('app.available_languages'))
                        ->tinyMce()
                        ->removable(),
                    Translatable::make('Описание', 'description')
                        ->languages(config('app.available_languages'))
                        ->hideOnIndex()
                        ->tinyMce()
                        ->removable(),

                    Number::make('Рейтинг', 'rating')
                        ->stars()
                        ->default(0)
                        ->min(0)
                        ->max(5),

                    BelongsTo::make("Автор", 'user', 'name')
                        // ->default(Auth::user())
                        ->searchable(),

                    // BelongsToMany::make('Туры', 'tours',  function($item) {
                    //     $cleanTitle = strip_tags($item->title);
                    //     return $cleanTitle;
                    // } )
                    //     ->hideOnIndex()
                    //     ->asyncSearch('title')
                    //     ->selectMode()


                ]),
                Tab::make('Изображения', [
                    MediaLibrary::make('Изображения', 'hotel_images')
                        ->multiple()
                        ->removable()
                ])
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
        return ['id', 'title->' . $language, 'user.name'];
    }
}
