<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use App\Filament\Resources\ProductsResource;
use Filament\Actions;
use App\Models\ProductImage;
use Filament\Resources\Pages\CreateRecord;

class CreateProducts extends CreateRecord
{
    protected static string $resource = ProductsResource::class;

    protected function afterCreate(): void
    {
        $images = $this->data['uploaded_images'] ?? [];

        foreach ($images as $image) {
            // Move each uploaded file into the public storage
            $path = $image->store('products', 'public');

            // Create a related ProductImage record
            ProductImage::create([
                'product_id' => $this->record->id,
                'image_path' => $path,
            ]);
        }
    }
}