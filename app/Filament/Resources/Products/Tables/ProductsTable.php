<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->square(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('family')
                    ->badge(),
                TextColumn::make('section')
                    ->formatStateUsing(fn(string $state): string => Product::SECTION_OPTIONS[$state] ?? $state)
                    ->searchable(),
                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('sub_images')
                    ->label('Sub Foto')
                    ->badge()
                    ->formatStateUsing(function (mixed $state): string {
                        $count = collect($state ?? [])
                            ->filter(function (mixed $item): bool {
                                if (is_string($item)) {
                                    return filled($item);
                                }

                                if (is_array($item)) {
                                    return filled($item['image'] ?? $item['path'] ?? null);
                                }

                                return false;
                            })
                            ->count();

                        return (string) $count;
                    }),
                IconColumn::make('is_featured')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
