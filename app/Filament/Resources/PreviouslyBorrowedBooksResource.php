<?php

namespace App\Filament\Resources;
use App\Filament\Resources\PreviouslyBorrowedBooksResource\RelationManagers;
use App\Filament\Resources\PreviouslyBorrowedBooksResource\pages;
use App\Models\BorrowingBooks;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;

class PreviouslyBorrowedBooksResource extends Resource
{

    protected static ?string $model = borrowingBooks::class;

    public static $hasCreateForm = false;

    public static $hasDeleteConfirmation = false;

    public static $hasEditForm = false;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';
    protected static ?string $navigationLabel = 'Previously borrowed Books';
    protected static ?string $modelLabel = 'Borrowed Books';
    protected static ?string $navigationGroup = 'Borrowing System';
    protected static ?string $slug = 'Previously-Borrowed-Books';

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->query(borrowingBooks::query()->where('return_state', true)->where('user_id', auth()->id()))

            ->columns([
                TextColumn::make('book_id')->label('Book ID')->sortable()->searchable(),
                TextColumn::make('book.title')->label('Book Title')->sortable()->searchable()->wrap(),
                TextColumn::make('borrowed_at')->label('Borrow Date')->sortable()->searchable()->date(),
                TextColumn::make('returned_at')->label('Return Time')->sortable()->searchable()->since(),

            ])
            ->filters([

                Filter::make('borrowed_at')
                    ->form([
                        DatePicker::make('Borrowed date'),
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['Borrowed date'] ?? null) {
                            $query->whereDate('borrowed_at', $data['Borrowed date']);
                        }
                    })->indicator('Filter by borrowed date'),
                Filter::make('returned_at')
                    ->form([
                        DatePicker::make('Return date'),
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['Return date'] ?? null) {
                            $query->whereDate('returned_at', $data['Return date']);
                        }
                    })->indicateUsing(function (array $data) : array{
                    $indicators = [];

                    if ($data['Borrowed date'] ?? null) {
                        $indicators[] = Indicator::make('Borrowed date ' . Carbon::parse($data['Borrowed date'])->toFormattedDateString())
                            ->removeField('Borrowed date');
                    }

                    if ($data['Return date'] ?? null) {
                        $indicators[] = Indicator::make('Return date ' . Carbon::parse($data['Return date'])->toFormattedDateString())
                            ->removeField('Return date');
                    }

                    return $indicators;
                })

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
            'index' => Pages\ListPreviouslyBorrowedBooks::route('/'),
            'create' => Pages\CreatePreviouslyBorrowedBooks::route('/create'),
            'edit' => Pages\EditPreviouslyBorrowedBooks::route('/{record}/edit'),
        ];
    }
}