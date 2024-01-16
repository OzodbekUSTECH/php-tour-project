<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\DayResource;
use App\MoonShine\Resources\HotelResource;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\TourResource;
use App\MoonShine\Resources\TypeResource;
use App\MoonShine\Resources\UserResource;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    protected function resources(): array
    {
        return [];
    }

    protected function pages(): array
    {
        return [];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make(static fn () => __('moonshine::ui.resource.system'), [
                MenuItem::make(
                    static fn () => __('moonshine::ui.resource.admins_title'),
                    new MoonShineUserResource()
                ),
                MenuItem::make(
                    static fn () => __('moonshine::ui.resource.role_title'),
                    new MoonShineUserRoleResource()
                ),
            ]),

            MenuGroup::make('Свои Модели', [
                MenuItem::make(
                    'Пользователи',
                    new UserResource()
                ),
                MenuItem::make(
                    'Туры',
                    new TourResource()
                ),
                MenuItem::make(
                    'Дни',
                    new DayResource()
                ),

                MenuItem::make(
                    'Отели',
                    new HotelResource()
                ),

                MenuItem::make(
                    'Типы',
                    new TypeResource()
                ),



            ]),

            MenuItem::make('Documentation', 'https://moonshine-laravel.com')
                ->badge(fn () => 'Check'),
        ];
    }

    /**
     * @return array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [];
    }
}
