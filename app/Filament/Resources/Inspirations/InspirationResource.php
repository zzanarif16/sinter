<?php

namespace App\Filament\Resources\Inspirations;

use App\Filament\Resources\Inspirations\Pages\CreateInspiration;
use App\Filament\Resources\Inspirations\Pages\EditInspiration;
use App\Filament\Resources\Inspirations\Pages\ListInspirations;
use App\Filament\Resources\Inspirations\Pages\ViewInspiration;
use App\Filament\Resources\Inspirations\Schemas\InspirationForm;
use App\Filament\Resources\Inspirations\Schemas\InspirationInfolist;
use App\Filament\Resources\Inspirations\Tables\InspirationsTable;
use App\Models\Inspiration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InspirationResource extends Resource
{
    protected static ?string $model = Inspiration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Inspiration';

    protected static string|UnitEnum|null $navigationGroup = 'CMS Interior';

    public static function form(Schema $schema): Schema
    {
        return InspirationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InspirationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InspirationsTable::configure($table);
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
            'index' => ListInspirations::route('/'),
            'create' => CreateInspiration::route('/create'),
            'view' => ViewInspiration::route('/{record}'),
            'edit' => EditInspiration::route('/{record}/edit'),
        ];
    }
}
