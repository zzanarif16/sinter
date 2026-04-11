<?php

namespace App\Filament\Resources\Abouts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AboutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('headline')
                    ->maxLength(255),
                Textarea::make('content')
                    ->rows(6)
                    ->columnSpanFull(),
                Textarea::make('vision')
                    ->rows(4)
                    ->columnSpanFull(),
                Textarea::make('mission')
                    ->rows(4)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->directory('abouts')
                    ->image()
                    ->imageEditor()
                    ->visibility('public'),
            ]);
    }
}
