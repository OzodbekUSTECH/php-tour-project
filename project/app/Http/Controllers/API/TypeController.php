<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Type\StoreTypeRequest;
use App\Http\Requests\Type\UpdateTypeRequest;
use App\Http\Resources\Type\TypeCollection;
use App\Http\Resources\Type\TypeResource;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Type;
use App\Utils\MediaHandler;

class TypeController extends Controller
{
    private $types_media = 'type_image';
    public function index($language)
    {
        app()->setLocale($language);

        $types = QueryBuilder::for(Type::class)
            ->allowedFilters(Type::filters())
            ->get();

        return new TypeCollection($types);
    }

    public function show($language, $id)
    {
        app()->setLocale($language);

        $type = Type::find($id);

        return new TypeResource($type);
    }

    public function store(StoreTypeRequest $request, $language)
    {
        app()->setLocale($language);
        $validated = $request->validated();

        $type = Type::create($validated);

        MediaHandler::downloadAllMediaFromRequest($request, $type, 'image', $this->types_media);

        return new TypeResource($type);
    }

    public function update(UpdateTypeRequest $request, $language, $id)
    {
        app()->setLocale($language);

        $validated = $request->validated();

        $type = Type::find($id);

        if($request->image){
            $type->clearMediaCollection($this->types_media);
        }

        MediaHandler::downloadAllMediaFromRequest($request, $type, 'image', $this->types_media);

        $type->update($validated);

        return new TypeResource($type);

    }

    public function destroy($language, Type $type)
    {
        $type->delete();
        return response()->noContent();
    }
}
