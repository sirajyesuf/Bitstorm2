<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\TextInput::make('title')
                ->required()
                ->columnSpan(2),

                Forms\Components\Select::make('category_id')
                ->label('Category')
                ->options(Category::all()->pluck('name', 'id'))
                ->required()
                ->columnSpan(2),


                Forms\Components\Select::make('brand_id')
                ->label('Brand')
                ->options(Brand::all()->pluck('name', 'id'))
                ->required(),

               
                Forms\Components\TextInput::make('price')
                ->required(),

                Forms\Components\Textarea::make('description')
                ->rows(4)
                ->required()
                ->columnSpan(2),

                Forms\Components\Toggle::make('is_featured')
                ->label('Featured')
                ->default(false),

                Forms\Components\FileUpload::make('image')
                ->required()
                ->columnSpan(2),

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('brand.name'),
                Tables\Columns\TextColumn::make('description')
                ->limit(20),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('Alerts')
                ->state(function (Model $record): float {
                    return $record->users()->count();
                })
            
            
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),

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
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
