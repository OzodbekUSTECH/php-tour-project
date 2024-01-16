<?php

namespace App\Traits;


use Spatie\Translatable\HasTranslations as BaseHasTranslations;
use Illuminate\Support\Facades\App;

trait HasTranslations
{
    use BaseHasTranslations;

    public function toArray()
    {
        $attributes = $this->attributesToArray(); // attributes selected by the query
        // remove attributes if they are not selected
        $translatables = array_filter($this->getTranslatableAttributes(), function ($key) use ($attributes) {
            return array_key_exists($key, $attributes);
        });
        foreach ($translatables as $field) {
            $attributes[$field] = $this->getTranslation($field, App::getLocale());
        }

        return array_merge($attributes, $this->relationsToArray());
    }
}
