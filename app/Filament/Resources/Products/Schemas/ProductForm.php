<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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
                    ->label('Foto Utama')
                    ->disk('public')
                    ->directory('products')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                    ->imageEditor()
                    ->fetchFileInformation(false)
                    ->visibility('public'),
                Repeater::make('sub_images')
                    ->label('Sub Foto (Maksimal 25)')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Foto Sub')
                            ->disk('public')
                            ->directory('products/sub')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->image()
                            ->imageEditor()
                            ->required()
                            ->fetchFileInformation(false)
                            ->visibility('public'),
                        TextInput::make('detail')
                            ->label('Detail Singkat')
                            ->maxLength(120)
                            ->placeholder('Contoh: Tekstur linen warna krem, cocok untuk ruang tamu minimalis.'),
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
                        ->take(25)
                        ->values()
                        ->all())
                    ->addActionLabel('Tambah Sub Foto')
                    ->reorderable()
                    ->maxItems(25)
                    ->defaultItems(0)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_featured')
                    ->label('Featured'),
            ]);
    }
}
