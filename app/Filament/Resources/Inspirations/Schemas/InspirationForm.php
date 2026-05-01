<?php

namespace App\Filament\Resources\Inspirations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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
                Repeater::make('sub_images')
                    ->label('Sub Foto (Maksimal 10)')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Foto Sub')
                            ->disk('public')
                            ->directory('inspirations/sub')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->image()
                            ->imageEditor()
                            ->required()
                            ->fetchFileInformation(false)
                            ->visibility('public'),
                        TextInput::make('detail')
                            ->label('Detail Singkat')
                            ->maxLength(120)
                            ->placeholder('Contoh: Kombinasi kayu dan linen untuk nuansa hangat.'),
                    ])
                    ->afterStateHydrated(function (Repeater $component, mixed $state): void {
                        $normalizedState = collect($state ?? [])
                            ->map(function (mixed $item): ?array {
                                if (is_string($item)) {
                                    return ['image' => $item, 'detail' => null];
                                }

                                if (! is_array($item)) {
                                    return null;
                                }

                                $image = $item['image'] ?? $item['path'] ?? null;

                                if (! filled($image)) {
                                    return null;
                                }

                                return [
                                    'image' => $image,
                                    'detail' => $item['detail'] ?? $item['caption'] ?? null,
                                ];
                            })
                            ->filter()
                            ->values()
                            ->all();

                        $component->state($normalizedState);
                    })
                    ->dehydrateStateUsing(fn(?array $state): array => collect($state ?? [])
                        ->map(function (mixed $item): ?array {
                            if (! is_array($item)) {
                                return null;
                            }

                            $image = $item['image'] ?? null;

                            if (! filled($image)) {
                                return null;
                            }

                            return [
                                'image' => $image,
                                'detail' => filled($item['detail'] ?? null) ? trim((string) $item['detail']) : null,
                            ];
                        })
                        ->filter()
                        ->take(10)
                        ->values()
                        ->all())
                    ->addActionLabel('Tambah Sub Foto')
                    ->reorderable()
                    ->maxItems(10)
                    ->defaultItems(0)
                    ->columnSpanFull(),
                Toggle::make('is_featured')
                    ->label('Featured'),
            ]);
    }
}
