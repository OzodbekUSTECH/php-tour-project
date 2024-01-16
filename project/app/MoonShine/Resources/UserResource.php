<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Email;
use MoonShine\Fields\Password;
use MoonShine\Fields\Relationships\HasMany;

class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Users';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('name'),
                Email::make("email"),
                Password::make("password"),
                HasMany::make("Туры", 'tours')
                    ->hideOnIndex()
                    ->creatable()
                    ->searchable()

            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }


    public function search(): array
    {
        return ['name'];
    }

}
