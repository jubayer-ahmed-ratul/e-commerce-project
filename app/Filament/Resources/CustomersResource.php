<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomersResource\Pages;
use App\Filament\Resources\CustomersResource\RelationManagers;
use App\Models\Customers;
use App\Models\UserType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;

use Filament\Forms\Components\Checkbox;

use Illuminate\Support\Str;

use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\Select;


class CustomersResource extends Resource
{
    protected static ?string $model = Customers::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Admin';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               TextInput::make('name'),
               TextInput::make('email'),
               TextInput::make('phone_number'),
               TextInput::make('shipping_address'),
               TextInput::make('billing_address'),

               Select::make('user_types_id')
                ->label('User Type')
                ->options(fn () => UserType::pluck('name', 'id')->toArray())
                ->searchable()
                ->preload()
                ->required()
                ->default(fn ($record) => $record?->user_types_id),
               
               Checkbox::make('create_user')
                ->label('Create Login Access')
                ->reactive(),

                TextInput::make('password')
                ->label('Generated Password')
                ->password()
                ->visible(fn($get) => $get('create_user'))
                ->default(fn() => Str::random(10))
                ->dehydrated(fn($get) => $get('create_user'))
                ->required(fn($get) => $get('create_user')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->searchable()
                ->sortable(),
                TextColumn::make('email')
                ->sortable(),
                TextColumn::make('phone_number')
                ->sortable(),
                TextColumn::make('shipping_address'),
                TextColumn::make('billing_address'),
                TextColumn::make('updated_at')
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomers::route('/create'),
            'edit' => Pages\EditCustomers::route('/{record}/edit'),
        ];
    }
}
