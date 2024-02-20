<?php

namespace App\Filament\Resources;
use App\Filament\Resources\BorrowRequestsResource\RelationManagers;
use App\Filament\Resources\BorrowRequestsResource\pages;
use App\Models\Book;
use App\Models\borrowingBooks;
use App\Models\borrow_requests;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables;
use Filament\Forms;


class BorrowRequestsResource extends Resource
{
    protected static ?string $model = borrow_requests::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';
    protected static ?string $navigationLabel = 'Borrow & Return Requests';
    protected static ?string $modelLabel = 'User Requests';
    protected static ?string $navigationGroup = 'Manage Book Requests';
    protected static ?string $slug = 'book-requests';

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->query(borrow_requests::query()->where('request_status', borrow_requests::Waiting)) //->where('type_request', borrow_requests::type_request1 ))
            ->columns([
                TextColumn::make('user_id')->label('User ID')->sortable()->searchable(),
                // TextColumn::make('user.name')->label('Member Name')->sortable()->searchable(),
                TextColumn::make('book_id')->label('Book ID')->sortable()->searchable(),
                TextColumn::make('book.title')->label('Book Title')->sortable()->searchable()->wrap(),
                TextColumn::make('borrow_due_date')->label('Due Date')->sortable()->searchable()->date(),
                TextColumn::make('book.status')->label('Book Status')->sortable()->searchable()->formatStateUsing(function (string $state) : string {
                    if ($state == 1) {
                        return 'Available';
                    } else {
                        return 'Issued';
                    }
                })
                    ->badge()
                    ->color(fn(string $state) : string => match ($state) {
                        '1' => 'info', // Change '1' to the value representing 'Available'
                        '0' => 'warning', // Change '2' to the value representing 'Issued'
                    }),
                TextColumn::make('type_request')->label('Request Type')->sortable()->searchable()
                    ->badge()
                    ->color(fn(string $state) : string => match ($state) {
                        borrow_requests::type_request1 => 'secondry',
                        borrow_requests::type_request2 => 'info2',
                    }),

            ])

            ->filters([
                SelectFilter::make('Book Title')
                    ->relationship('book', 'title')
                    ->searchable()->preload()
                    ->indicator('Filter by book title'),
                SelectFilter::make('User name')
                    ->relationship('user', 'name')
                    ->searchable()->preload()
                    ->indicator('Filter by user name')->options(
                    \App\Models\User::all()->pluck('name', 'id')->toArray()
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('Accept')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->action(function ($record) {
                        $Book = new Book();
                        $borrowedBook = new borrowingBooks();

                        $record->update(['request_status' => borrow_requests::Accepted]);
                        $book = $Book::find($record->book_id);

                        // Check if the book exists
                        if ($book) {
                            // Update the status field of the related book
                            if ($record->type_request == borrow_requests::type_request1) {
                                $book->update(['status' => $Book::Issued]);

                                Notification::make()
                                    ->title('Borrow Request Accepted')
                                    ->success()
                                    ->send();

                                $borrowedBook->book_id = $record->book_id;
                                $borrowedBook->borrowed_at = now();
                                $borrowedBook->user_id = $record->user_id;

                                $borrowedBook->save();

                            } else {
                                $book->update(['status' => $Book::Available]);

                                $borBooks = borrowingBooks::where('book_id', $record->book_id)
                                    ->where('return_state', false)
                                    ->get();

                                foreach ($borBooks as $bor) {
                                    $bor->update(['return_state' => true]);
                                    $bor->update(['returned_at' => now()]);

                                }

                                Notification::make()
                                    ->title('Return Request Accepted')
                                    ->success()
                                    ->send();

                            }

                        }

                    }),

                Tables\Actions\Action::make('Reject')
                    ->visible(function ($record) {
                        return $record->type_request == borrow_requests::type_request1;
                    })
                    ->icon('heroicon-m-minus')
                    ->color('danger')
                    ->action(function ($record) {
                        $record->update(['request_status' => borrow_requests::Rejected]);

                        Notification::make()
                            ->title('Borrow Request Rejected')

                            ->success()
                            ->send();
                    }),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations() : array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBorrowRequests::route('/'),
            'create' => Pages\CreateBorrowRequests::route('/create'),
            'edit' => Pages\EditBorrowRequests::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}