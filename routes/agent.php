<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Agent\AgentProfileController;
use App\Http\Controllers\Agent\AgentPropertyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\Agent\Auth\AgentRegistrationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\FcmController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\VisitRequestController;
use App\Models\Property;
use App\Models\VisitRequest;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/FUCKUMACK', function () {
    // logger('FUCKUMACK');
    return response()->json([
        'status' => 'success',
        'message' => 'FUCKUMACK',
    ], 200);
})
    ->middleware('auth:sanctum')
;



Route::prefix('/agents')->group(function () {
    $currentUri = request()->path();
    logger('Agent Routes  ::>>  ' . $currentUri);
    // Agent Routes
    /**
     * Authentication Routes
     */
    Route::post('/register', [AgentRegistrationController::class, 'register']);
    Route::post('/login', [AgentRegistrationController::class, 'login']);
    Route::post('/logout', [AgentRegistrationController::class, 'logout'])->middleware('auth:sanctum');
    // Route::post('/password/forgot', [AgentRegistrationController::class, 'forgotPassword'])->middleware('auth:sanctum');
    Route::post('/password/reset', [AgentRegistrationController::class, 'resetPassword'])->middleware('auth:sanctum');

    Route::post('/password/forgot', [AgentRegistrationController::class, 'forgotPassword']);


    Route::get('verify-auth', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'message' => 'User is authenticated',
            'user' => $request->user(),
        ]);
    })->middleware('auth:sanctum');






    // Agent- amenities
    Route::get('/amenities', [AmenityController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/amenities', [AmenityController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/amenities/{id}', [AmenityController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/amenities/{id}', [AmenityController::class, 'destroy'])->middleware('auth:sanctum');
    // Agent - properties
    Route::get('/properties', [AgentPropertyController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/properties/{id}', [AgentPropertyController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/properties', [AgentPropertyController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/properties/{property}', [AgentPropertyController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/properties/{id}', [AgentPropertyController::class, 'destroy'])->middleware('auth:sanctum');
    Route::get('/property/most-viewed', [AgentPropertyController::class, 'getMostViewedProperty'])->middleware('auth:sanctum');
    Route::post('/properties/{property}/image-delete', [AgentPropertyController::class, 'deleteImage'])->middleware('auth:sanctum');
    Route::get('/properties/{property}/images', [AgentPropertyController::class, 'getImages'])->middleware('auth:sanctum');


    /**
     IGNORE FOR NOW
     */
    #agent properties-amenities
    Route::put('/properties/attach-amenity/{propertyId}/{amenityId}', [PropertyController::class, 'attachAmenity'])->middleware('auth:sanctum');
    Route::delete('/properties/detach-amenity/{propertyId}/{amenityId}', [PropertyController::class, 'detachAmenity'])->middleware('auth:sanctum');
    /**
    END IGNORE FOR NOW
     */


    // Agent - feedback
    Route::get('/properties/{property}/feedback', [FeedbackController::class, 'getFeedbackForProperty'])->withoutMiddleware('auth:sanctum');

    // Agent - count property feedbacks and visitRequests
    Route::get('/count-property/{propertyId}/feedbacks', [PropertyController::class, 'countPropertyFeedbacks'])->middleware('auth:sanctum');
    Route::get('/count-property/{propertyId}/visitRequests', [PropertyController::class, 'countPropertyVisitRequests'])->middleware('auth:sanctum');

    // agent -  image upload
    Route::post('/upload-image', [ImageController::class, 'store'])->middleware('auth:sanctum'); // For image upload
    // agent - visitRequests
    Route::get('/visit-requests', [VisitRequestController::class, 'list'])->middleware('auth:sanctum'); // List all visit requests for authenticated user

    // agent  - seraching
    Route::get('/search/properties', [SearchController::class, 'search'])->middleware('auth:sanctum');

    // Agent - visit requests
    Route::put('/visit-requests/approve/{visitRequest}', [VisitRequestController::class, 'approveVisitRequest'])->middleware('auth:sanctum');
    Route::put('/visit-requests/reject/{visitRequest}', [VisitRequestController::class, 'rejectVisitRequest'])->middleware('auth:sanctum');



    // Profile Routes
    Route::post('/profile', [AgentProfileController::class, 'updateProfile'])->middleware('auth:sanctum');
    Route::post('/profile/password', [AgentProfileController::class, 'updatePassword'])->middleware('auth:sanctum');
    Route::get('/get-user-data', [AgentProfileController::class, 'getUserData'])->middleware('auth:sanctum');


    Route::get('/home/count', function () {

        $availablePropertiesCount = Property::where('user_id', Auth::id())->where('status', 'available')->count();
        $allPropertiesCount = Property::where('user_id', Auth::id())->count();

        return response()->json([
            'status' => 'success',
            'available_properties_count' => $availablePropertiesCount,
            'all_properties_count' => $allPropertiesCount,
        ], 200);
    })->middleware('auth:sanctum');




    // Route::get('/get-user-data', function () {
    //     return response()->json([
    //         'status' => 'success',
    //         'user' => request()->user(),
    //     ], 200);
    // })->middleware('auth:sanctum');
});
