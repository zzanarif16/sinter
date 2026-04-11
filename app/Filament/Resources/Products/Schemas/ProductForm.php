<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('family')
                    ->options(Product::FAMILY_OPTIONS)
                    ->required(),
                Select::make('section')
                    ->options(Product::SECTION_OPTIONS)
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('short_description')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->rows(8)
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->numeric(),
                FileUpload::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->directory('products')
                    ->image()
                    ->imageEditor()
                    ->visibility('public'),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_featured')
                    ->label('Featured'),
            ]);
    }
}
