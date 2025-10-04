<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatagoriesResource\Pages;
use App\Filament\Resources\CatagoriesResource\RelationManagers;
use App\Models\Catagories;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;

use Illuminate\Support\Str;

use Filament\Forms\Components\Toggle;

use Filament\Forms\Components\Select;

use Filament\Forms\Components\RichEditor;

use Filament\Forms\Components\Section;

use Filament\Forms\Components\Grid;

use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Columns\IconColumn;

class CatagoriesResource extends Resource
{
    protected static ?string $model = Catagories::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
       return $form
    ->schema([
        Section::make()
            ->schema([
                Grid::make(2) // 👈 create 2-column grid (Name + Slug in same row)
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('slug', Str::slug($state))
                            ),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->readOnly(),
                    ]),

                Select::make('parent_id')
                    ->label('Parent')
                    ->options(\App\Models\Catagories::all()->pluck('name', 'id'))
                    ->searchable(),

                Toggle::make('visibility'),

                RichEditor::make('description')
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
            ]),
    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->searchable()
                ->sortable(),
                TextColumn::make('parent')
                ->sortable(),
                IconColumn::make('visibility')
                ->boolean(),
                TextColumn::make('updated_at'),
                


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
            'index' => Pages\ListCatagories::route('/'),
            'create' => Pages\CreateCatagories::route('/create'),
            'edit' => Pages\EditCatagories::route('/{record}/edit'),
        ];
    }
}
