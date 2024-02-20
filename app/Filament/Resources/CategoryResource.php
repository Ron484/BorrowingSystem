<?php

namespace App\Filament\Resources;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\CategoryResource\pages;
use App\Models\Category;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;


class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Book categories';
    protected static ?string $modelLabel = 'Book categories';
    protected static ?string $navigationGroup = 'Books System';
    protected static ?string $slug = 'book-category';

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Category Name')
                    ->live()
                    ->required()->minLength(1)->maxLength(250),
            ])->columns(1);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Category Name')->sortable()->searchable()->weight(FontWeight::Bold)

                ,
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

    public static function getRelations() : array
    {
        return [
            //
        ];
    }

    public static function getPages() : array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}