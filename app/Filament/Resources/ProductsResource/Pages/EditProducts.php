<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use App\Filament\Resources\ProductsResource;
use Filament\Actions;
use App\Models\ProductImage;
use Filament\Resources\Pages\EditRecord;

class EditProducts extends EditRecord
{
    protected static string $resource = ProductsResource::class;

    protected function afterSave(): void
    {
        $images = $this->data['uploaded_images'] ?? [];

        foreach ($images as $image) {
            $path = $image->store('products', 'public');

            ProductImage::create([
                'product_id' => $this->record->id,
                'image_path' => $path,
            ]);
        }
    }
}
