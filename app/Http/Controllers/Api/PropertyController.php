<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\PropertyResource;
use App\Models\Api\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PropertyController extends Controller
{

    /**
     * @var Property
     */
    private $property;

    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    /**
     * Display a listing of the resource.
     *
     * @return PropertyCollection
     */
    public function index()
    {
        $properties = $this->property->paginate(10);

        return new PropertyCollection($properties);
    }

    /**
     * Display a listing of the resource.
     *
     * @return PropertyResource
     */
    public function show(int $id)
    {
        $property = $this->property->find($id);

        return new PropertyResource($property);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PropertyRequest $request
     * @return JsonResponse
     */
    public function store(PropertyRequest $request): JsonResponse
    {
        $this->property->owner_id = '1';
        $this->property->title = $request->title;
        $this->property->description = $request->description;
        $this->property->rental_price = $request->rental_price;
        $this->property->sale_price = $request->sale_price;
        $this->property->slug = Str::slug($request->title);
        $this->property->save();

        return response()->json(['status' => 'success', 'data' => $this->property]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PropertyRequest $request
     * @return JsonResponse
     */
    public function update(PropertyRequest $request): JsonResponse
    {
        $data = $request->all();
        $data['slug'] = $this->slugUpdate($data);
        $property = $this->property->find($data['id']);
        $property->update($data);

        return response()->json(['data' => new PropertyResource($property), 'message' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $property = $this->property->find($id);
        $property->delete();

        return response()->json(['msg' => 'Imóvel removido com sucesso']);
    }

    protected function slugUpdate(Array $property)
    {
        $slug = Str::slug($property['title']);

        return $slug;
    }
}
