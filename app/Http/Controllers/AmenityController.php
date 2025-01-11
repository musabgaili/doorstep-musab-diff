<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Property;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Illuminate\Support\Facades\Log;




class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    #[OA\Get(
        path: '/api/amenities',
        description: 'getting all amenities',
        tags: ['All Amenities'],
        security : [["bearerAuth" => []]],
    )]


    #[OA\Get(
        path: '/api/agents/amenities',
        description: 'getting all amenities',
        tags: ['All Amenities'],
        security : [["bearerAuth" => []]],
    )]
    #[OA\Parameter(
        name: 'Authorization',
        in: 'header',
        description: 'Bearer {token}',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'Fetching all amenities',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'success'),
                new OA\Property(property: 'message', type: 'string', example: 'amenities are fetched successfully!'),

                new OA\Property(
                    property: 'amenities',
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'name', type: 'integer', example:  'wifi'),
                        new OA\Property(property: 'icon', type: 'string', example: 'icon'),
                        new OA\Property(property: 'category', type: 'string', example: 'category 1')
                    ]
                )
            ]
        )
    )]
    public function index()
    {
        logger('Getting all amenities');
        $amenities = Amenity::all();
        return response()->json([
            'status' => 'success',
            'message' => 'The amenities are fetched successfully',
            'amenities' => $amenities,
        ] , 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    #[OA\Post(
        path: '/api/agents/amenities',
        description: 'craete an amenity',
        tags: ['Create an amenity'],
        security : [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                    new OA\Property(property: 'icon', type: 'string', format: 'email', example: 'icon 1')
                ]
            )
        )
        )]
        #[OA\Parameter(
            name: 'Authorization',
            in: 'header',
            description: 'Bearer {token}',
            required: true,
            schema: new OA\Schema(type: 'string')
        )]
    #[OA\Post(
        path: '/api/agents/amenities',
        description: 'craete an amenity',
        tags: ['Create an amenity'],
        security : [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                    new OA\Property(property: 'icon', type: 'string', format: 'email', example: 'icon 1')
                ]
            )
        )
        )]
        #[OA\Parameter(
            name: 'Authorization',
            in: 'header',
            description: 'Bearer {token}',
            required: true,
            schema: new OA\Schema(type: 'string')
        )]
    #[OA\Response(
        response: 200,
        description: 'create an amenity',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'success'),
                new OA\Property(property: 'message', type: 'string', example: 'the amenity is created successfully!'),

                new OA\Property(
                    property: 'agents',
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'icon', type: 'integer', example: "icon"),
                        new OA\Property(property: 'name', type: 'string', example: 'wifi'),
                        new OA\Property(property: 'category', type: 'string', example: 'cateory 2')
                    ]
                )
            ]
        )
    )]
    public function store(Request $request)
    {
        //
        $fields = $request->validate([
            'name' => 'required',
            'icon' => 'required'
        ]);
        $amenity = Amenity::create($fields);
        return response()->json([
            'status' => 'success',
            'message' => 'The amenity is created successfully',
            'amenity' => $amenity
        ] , 200);
    }



    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param string $id
     * @return Response
     */
    #[OA\Put(
        path: '/api/agents/amenities/{id}',
        description: 'Update amenity',
        tags: ['Update amenity'],
        security : [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                    new OA\Property(property: 'icon', type: 'string', format: 'email', example: 'icon 1')
                ]
            )
                ),
        parameters: [new OA\Parameter(
            name: "id",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )],
    )]
    #[OA\Parameter(
        name: 'Authorization',
        in: 'header',
        description: 'Bearer {token}',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'Updating amenity',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'success'),
                new OA\Property(property: 'message', type: 'string', example: 'The amenity is updated successfully!'),

                new OA\Property(
                    property: 'amenity',
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'icon', type: 'integer', example: 'icon'),
                        new OA\Property(property: 'name', type: 'string', example: 'wifi'),
                        new OA\Property(property: 'category', type: 'string', example: 'cat 2')
                    ]
                )
            ]
        )
    )]

    public function update(Request $request, string $id)
    {
        //
        $amenity = Amenity::findOrFail($id);
        $fields = $request->validate([
            'name' => 'required',
            'icon' => 'required'
        ]);
        $amenity->update($fields);
        return response()->json([
            'status' => 'success',
            'message' => 'The amenity is updated successfully',
            'amenity' => $amenity
        ] , 200);

    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return Response
     */
    #[OA\Delete(
        path: '/api/agents/amenities/{id}',
        description: 'Deleting amenity',
        tags: ['Delete amenity'],
        security : [["bearerAuth" => []]],

        parameters: [new OA\Parameter(
            name: "id",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )],
    )]
    #[OA\Parameter(
        name: 'Authorization',
        in: 'header',
        description: 'Bearer {token}',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'Deleting amenity',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'success'),
                new OA\Property(property: 'message', type: 'string', example: 'amenity is deleted successfully!'),


            ]
        )
    )]
    public function destroy(string $id)
    {
        //
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();
        return response()->json([
            'status' => 'succcess',
            'message' => 'The amenity is deleted successfully'
        ] , 200);
    }



    // Method to get nearby amenities for a specific property
    #[OA\Get(
        path: '/api/properties/{propertyId}/amenities',
        description: 'get nearby amenities',
        tags: ['Nearby amenities'],
        security : [["bearerAuth" => []]],
        parameters: [new OA\Parameter(
            name: "propertyId",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )],

    )]
    #[OA\Parameter(
        name: 'Authorization',
        in: 'header',
        description: 'Bearer {token}',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'get nearby amenities',
        content: new OA\JsonContent(
            type: 'object',
            properties: [


                new OA\Property(
                    property: 'property',
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'title', type: 'integer', example: "villa"),
                        new OA\Property(property: 'description', type: 'string', example: 'beside somewhere'),
                        new OA\Property(property: 'price', type: 'string', example: '$1000')
                    ]
                    ),
                new OA\Property(
                    property: 'amenities',
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'icon', type: 'integer', example: "icon"),
                        new OA\Property(property: 'name', type: 'string', example: 'wifi'),
                        new OA\Property(property: 'category', type: 'string', example: 'cat 2')
                    ]
                )
            ]
        )
    )]
    public function getNearbyAmenities($propertyId, Request $request)
{
    // Find the property by ID
    $property = Property::findOrFail($propertyId);

    // Set the distance threshold (in kilometers or miles)
    $distance = $request->input('distance', 5); // Default to 5 km

    // Query to find nearby amenities within the distance range
    $amenitiesQuery = Amenity::selectRaw("
    id, name, address, category, latitude, longitude,
    (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
", [$property->latitude, $property->longitude, $property->latitude])
->having('distance', '<=', $distance)
->orderBy('distance', 'asc');

// Log the SQL query with parameters
$sql = $amenitiesQuery->toSql();
Log::info('Generated SQL Query: ' . $sql);

// Check if the query is being executed properly
$boundParams = $amenitiesQuery->getBindings();
Log::info('SQL Query Parameters: ', $boundParams);

// Execute the query to get results
$amenities = $amenitiesQuery->get();



    return response()->json([
        'property' => $property,
        'amenities' => $amenities
    ]);
}
    }



