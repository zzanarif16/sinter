<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('whatsapp')
                    ->maxLength(255),
                TextInput::make('instagram')
                    ->maxLength(255),
                Textarea::make('address')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('business_hours')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('map_embed')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
