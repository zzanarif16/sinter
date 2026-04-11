<?php

namespace App\Filament\Resources\Inspirations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InspirationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('summary')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->rows(8)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->directory('inspirations')
                    ->image()
                    ->imageEditor()
                    ->visibility('public'),
                Toggle::make('is_featured')
                    ->label('Featured'),
            ]);
    }
}
