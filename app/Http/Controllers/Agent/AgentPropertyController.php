<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Property;
use App\Notifications\PropertyAddedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Services\PropertyImageService;

class AgentPropertyController extends Controller
{
    protected $propertyImageService;

    public function __construct(PropertyImageService $propertyImageService)
    {
        $this->propertyImageService = $propertyImageService;
    }

    public function index()
    {
        logger('Getting all properties');

        $properties = Property::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Properties retrieved successfully',
            'properties' => $properties
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'area' => 'nullable|integer',
            // 'image.*' => 'required|image|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $request->merge([
            'user_id' => auth()->user()->id,
            'status' => 'available',
            'view_count' => 0
        ]);

        $property = Property::create($request->all());

        if ($request->hasFile('images')) {
            logger('HAS IMAGES');
            // $images = $request->file('images');
            // foreach ($images as $image) {
            // $this->propertyImageService->store($property, $images);
            $this->propertyImageService->store($property, $request);

            // }
        }

        logger($property);
        logger($property->getMedia('properties'));

        return response()->json([
            'status' => 'success',
            'message' => 'Property created successfully and users are notified',
            'property' => $property,
            'image_url' => $this->propertyImageService->getMainImageUrl($property)
        ], 201);
    }

    public function show(string $id)
    {
        $property = Property::findOrFail($id);
        // Why the hill he is makin views increment ?????😂😂😂😂😂
        // this is agent controller 😂😂😂😂😂
        // $property->increment('view_count');

        return response()->json([
            'success' => true,
            'data' => $property,
        ], 200);
    }

    public function update(Request $request, Property $property)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'location' => 'nullable|string|max:255',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'area' => 'nullable|integer',
            'property_type' => 'nullable|string',
            'status' => 'in:available,sold,reserved',
            'discount' =>  'numeric|nullable',
            'images' => 'nullable|array',
            // 'image' => 'nullable|image|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $property->update($request->all());

        if ($request->hasFile('images')) {
            logger('HAS IMAGES');
            $this->propertyImageService->update($property, $request);
        }


        $freshProperty = $property->fresh();

        return response()->json([
            'status' => 'success',
            'message' => 'Property updated successfully',
            'property' => $property,
            'image_url' => $this->propertyImageService->getMainImageUrl($property)
        ], 200);
    }

    public function destroy(string $id)
    {
        $property = Property::findOrFail($id);
        $property->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Property is deleted successfully',
        ], 200);
    }

    public function attachAmenity(string $propertyId, string $amenityId)
    {
        $property = Property::findOrFail($propertyId);
        $property->addAmenity($amenityId);
        return response()->json([
            'status' => 'success',
            'message' => 'The amenity is attached successfully',
        ], 200);
    }

    public function detachAmenity(string $propertyId, string $amenityId)
    {
        $property = Property::findOrFail($propertyId);
        $property->detachAmenity($amenityId);
        return response()->json([
            'status' => 'success',
            'message' => 'The amenity is detached successfully',
        ], 200);
    }



    public function countPropertyVisitRequests($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $totalVisitRequests = $property->getTotalVisitRequests();

        return response()->json([
            'property_id' => $property->id,
            'total_visit_requests' => $totalVisitRequests
        ]);
    }



    public function getMostViewedProperty()
    {
        $property = Property::where('user_id', auth()->user()->id)
            ->orderBy('view_count', 'desc')
            ->first();

        if (!$property) {
            return response()->json(['message' => 'No property found'], 404);
        }

        return response()->json([
            'message' => 'success',
            'property' =>  $property
        ]);
    }


    ///
    public function deleteImage(Property $property, Request $request)
    {
        // $x = json_decode($request->image);
        logger($request->image['uuid']);
        // logger(json_encode($request->image)->uuid);
        // return ;
        // $uuid = $request->uuid;
        $media = Media::where('uuid', $request->image['uuid'])->first();
        logger( "Property is". $property->id . " && Media is". $media);

        if ($media && $media->model_id === $property->id) {
            return $media->delete();
        }

        return false;
    }

    public function getImages(Property $property)
    {
        return response()->json([
            'images' => $property->getMedia('properties')
        ]);
    }
}
