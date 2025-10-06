<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsResource\Pages;
use App\Filament\Resources\ProductsResource\RelationManagers;
use App\Models\Products;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Section;

use Filament\Forms\Components\TextInput;

use Illuminate\Support\Str;

use Filament\Forms\Components\Grid;

use Filament\Forms\Components\RichEditor;

use Filament\Forms\Components\FileUpload;

use Filament\Forms\Components\Checkbox;

use Filament\Forms\Components\Toggle;

use Filament\Forms\Components\DatePicker;

use Filament\Forms\Components\Select;

use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Columns\ImageColumn;

use Filament\Tables\Columns\IconColumn;

class ProductsResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Basic Info')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Name')
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(fn($state, callable $set) =>
                                    $set('slug', \Illuminate\Support\Str::slug($state))
                                ),

                            TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->readOnly(),
                        ]),
                    RichEditor::make('description'),
                ]),

            Section::make('Images')
                ->schema([
                    FileUpload::make('uploaded_images')
                        ->label('Product Images')
                        ->multiple()
                        ->directory('products') // stored in storage/app/public/products
                        ->storeFiles(false) // disable auto storage, we’ll handle manually
                        ->dehydrated(false), // don’t try to save directly to products table
                ]),

            Section::make('Pricing')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('price'),
                            TextInput::make('compare_at_price'),
                            TextInput::make('cost_per_item'),
                        ]),
                ]),

            Section::make('Inventory')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('sku')->label('SKU'),
                            TextInput::make('barcode')->label('Barcode'),
                            TextInput::make('quantity'),
                            TextInput::make('security_stock'),
                        ]),
                ]),

            Section::make('Shipping')
                ->schema([
                    Checkbox::make('shiping')->label('This product will be shipped'),
                ]),

            Section::make('Status')
                ->schema([
                    Toggle::make('visibility'),
                    DatePicker::make('published_at'),
                ]),

            Section::make('Associations')
                ->schema([
                    Select::make('brand')
                        ->label('Brand')
                        ->options(\App\Models\Brand::pluck('name', 'id'))
                        ->searchable(),

                    Select::make('catagories')
                        ->label('Category')
                        ->options(\App\Models\Catagories::pluck('name', 'id'))
                        ->searchable(),
                ]),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images.image_path')
                ->label('Image')
                ->square()
                ->limit(1), // show first image
                TextColumn::make('name')
                ->sortable(),
                TextColumn::make('brand')
                ->sortable(),
                IconColumn::make('visibility')
                ->boolean()
                ->sortable(),
                TextColumn::make('price')
                ->sortable(),
                TextColumn::make('sku')
                ->sortable(),
                TextColumn::make('quantity')
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProducts::route('/create'),
            'edit' => Pages\EditProducts::route('/{record}/edit'),
        ];
    }
}
