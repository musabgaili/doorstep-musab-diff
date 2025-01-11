<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class PropertyImageService
{
    /**
     * Store a new property image
     */
    public function store(Property $property, Request $request): void
    {
        foreach ($request->file('images') as $image) {
            $property->addMedia($image)->toMediaCollection('properties');
        }
    }

    /**
     * Update property image
     */
    public function update(Property $property, Request $request): void
    {

        logger("WWWWWWW");
        // This will automatically remove the old image since we're using singleFile()
        // $property->clearMediaCollection('properties');
        foreach ($request->file('images') as $image) {
            $property->addMedia($image)->toMediaCollection('properties');
        }
    }

    /**
     * Get the property's main image URL
     */
    public function getMainImageUrl(Property $property): ?string
    {
        return $property->getFirstMediaUrl('properties');
    }
}
