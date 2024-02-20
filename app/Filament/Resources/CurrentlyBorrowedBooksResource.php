<?php

namespace App\Filament\Resources;
use App\Filament\Resources\CurrentlyBorrowedBooksResource\RelationManagers;
use App\Filament\Resources\CurrentlyBorrowedBooksResource\pages;
use App\Models\BorrowingBooks;
use App\Models\borrow_requests;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;


class CurrentlyBorrowedBooksResource extends Resource
{
    protected static ?string $model = borrowingBooks::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';
    protected static ?string $navigationLabel = 'Currently borrowed Books';
    protected static ?string $modelLabel = 'Borrowed Books';
    protected static ?string $navigationGroup = 'Borrowing System';
    protected static ?string $slug = 'Borrowed-Books';

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

            ->query(borrowingBooks::query()->where('return_state', false)->where('user_id', auth()->id()))

            ->columns([
                TextColumn::make('book_id')->label('Book ID')->sortable()->searchable(),
                TextColumn::make('book.title')->label('Book Title')->sortable()->searchable()->wrap(),
                TextColumn::make('borrowed_at')->label('Borrow Date')->sortable()->searchable()->since(),
                TextColumn::make('return_state')
                    ->label('Due Date')
                    ->formatStateUsing(function ($record) {
                        $dueDate = borrow_requests::getDueDate($record->book_id, $record->user_id);
                        return $dueDate ? $dueDate : '';
                    }),
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

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Return')
                    ->visible(function ($record) {
                        return $record->return_state == false;
                    })

                    ->color('info')
                    ->icon('heroicon-m-plus')
                    ->action(function ($record) : void{
                        $existingRequest = borrow_requests::where('book_id', $record->book_id)
                            ->where('user_id', auth()->id())
                            ->where('request_status', borrow_requests::Waiting)
                            ->where('type_request', borrow_requests::type_request2)
                            ->first();

                        if (!$existingRequest) {
                            $borrowedBook = new borrow_requests();
                            $borrowedBook->book_id = $record->book_id;
                            $borrowedBook->user_id = auth()->id();
                            $borrowedBook->type_request = borrow_requests::type_request2;
                            $borrowedBook->borrow_due_date = borrow_requests::getDueDate($record->book_id, $record->user_id);

                            $borrowedBook->save();

                            Notification::make()
                                ->title('Send Request Successfluy')

                                ->success()
                                ->send();
                        }
                    }),

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
            'index' => Pages\ListCurrentlyBorrowedBooks::route('/'),
            'create' => Pages\CreateCurrentlyBorrowedBooks::route('/create'),
            'edit' => Pages\EditCurrentlyBorrowedBooks::route('/{record}/edit'),
        ];
    }
}