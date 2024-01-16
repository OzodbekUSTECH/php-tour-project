<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
use MoonShine\Fields\Relationships\BelongsToMany;

use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\HasMany;

class TourResource extends ModelResource
{
    protected string $model = Tour::class;

    protected string $title = 'Tours';


    // protected bool $editInModal = true;
    // protected bool $createInModal = true;

    // public function query(): Builder
    // {
    //     return parent::query()->where('user_id', 2);
    // }

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

                    Number::make('Цена(USD)', 'price'),
                    BelongsTo::make("Автор", 'user', 'name')
                        // ->default(Auth::user())
                        ->searchable()
                        ->nullable()

                ]),

                Tab::make('Типы', [
                    BelongsToMany::make('Типы', 'types', 'name')
                        ->columnLabel('Название')
                        ->inLine('', true)
                        ->selectMode()
                        ->creatable()
                        ->searchable()
                        ->placeholder('Типы'),
                ]),


                Tab::make('Изображения', [
                    MediaLibrary::make('Изображения', 'tour_images')
                        ->multiple()
                        ->removable()
                ]),

                Tab::make('Отели', [
                    BelongsToMany::make('Отели', 'hotels', function ($item) {
                        $cleanTitle = strip_tags($item->title);
                        $stars = str_repeat('★', $item->rating);
                        return "$cleanTitle - $stars ($item->rating)";
                    })
                        ->hideOnIndex()
                        ->selectMode()
                        ->creatable()
                        ->searchable()
                        ->placeholder('Отели'),

                ]),

                Tab::make("Маршрут/Дни", [
                    HasMany::make("Дни", 'days')
                        ->hideOnIndex()
                        ->creatable()
                        ->fields([
                            ID::make()->sortable(),
                            Translatable::make('Название', 'title')
                        ])

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
        return ['id', 'title->' . $language, 'user.name'];
    }
}
