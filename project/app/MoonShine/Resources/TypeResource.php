<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Type;

use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Relationships\BelongsToMany;
use VI\MoonShineSpatieTranslatable\Fields\Translatable;
use MoonShine\Fields\Slug;
use VI\MoonShineSpatieMediaLibrary\Fields\MediaLibrary;

class TypeResource extends ModelResource
{
    protected string $model = Type::class;

    protected string $title = 'Types';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Translatable::make('Название', 'name')
                    ->languages(config('app.available_languages'))
                    ->removable(),

                Slug::make('URL', 'url')
                    ->from('name')
                    ->separator('-')
                    ->unique(),

                BelongsToMany::make('Туры', 'tours',  function ($item) {
                    $cleanTitle = strip_tags($item->title);
                    return $cleanTitle;
                })
                    ->searchable()
                    ->hideOnIndex()
                    ->hideOnCreate()
                    ->selectMode(),

                MediaLibrary::make('Изображение', 'type_image')
                    ->removable()
                    
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
