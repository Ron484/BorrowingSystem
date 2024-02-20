<?php

namespace App\Filament\Resources;
use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use Filament\Tables;
use Filament\Forms;
use App\Models\Book;
use App\Models\borrow_requests;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as SectionInfoList;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;


class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'All Books';
    protected static ?string $navigationGroup = 'Books System';
    protected static ?string $slug = 'library-books';

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                Section::make('Book Details')->columns(2)->schema(
                    [

                        TextInput::make('title')
                            ->live()
                            ->required()
                            ->minLength(1)
                            ->maxLength(150),

                        Select::make('status')
                            ->options([
                                Book::Available => 'Available',
                                Book::Issued => 'Issued',

                            ]
                            )->native(false)->default(1),
                    ]),
                Section::make('Book Content')->columns(2)->schema(
                    [
                        RichEditor::make('description')
                            ->fileAttachmentsDirectory('books/booksImages')
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->image()
                            ->directory('books/mainImages'),

                        TextInput::make('pages')
                            ->numeric(),
                    ]
                ),
                Section::make('Author and Categories')->columns(3)->schema(
                    [
                        TextInput::make('author')
                            ->required()
                            ->maxLength(150),

                        TextInput::make('publisher')
                            ->required()
                            ->maxLength(150),

                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()->native(false)->searchable()->preload(),
                    ]
                ),
            ]);

    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('title')->sortable()->searchable()->wrap(),
                TextColumn::make('status')->sortable()->searchable()->formatStateUsing(function (string $state) : string {
                    if ($state == 1) {
                        return 'Available';
                    } else {
                        return 'Issued';
                    }
                })->badge()
                    ->color(fn(string $state) : string => match ($state) {
                        '1' => 'success', // Change '1' to the value representing 'Available'
                        '0' => 'warning', // Change '2' to the value representing 'Issued'
                    }),

                TextColumn::make('category.name')->sortable()->searchable(),

            ])
            ->filters([
                SelectFilter::make('Book Category')
                    ->relationship('category', 'name')
                    ->searchable()->preload()
                    ->label('Book Category')->indicator('Filter by Category'),
                Filter::make('status')
                    ->query(function ($query) {
                        $query->where('status', Book::Available);
                    })
                    ->label('Is available'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('Borrow')

                    ->visible(function ($record) {
                        return $record->isAvailable() && (auth()->check() && auth()->user()->role === 'USER');
                    })
                    ->color('info')
                    ->icon('heroicon-m-plus')
                    ->action(function ($record, array $data) : void{
                        $existingRequest = borrow_requests::where('book_id', $record->id)
                            ->where('user_id', auth()->id())
                            ->where('request_status', borrow_requests::Waiting)
                            ->where('type_request', borrow_requests::type_request1)

                            ->first();

                        if (!$existingRequest) {
                            $borrowedBook = new borrow_requests();
                            $borrowedBook->book_id = $record->id;
                            $borrowedBook->borrow_due_date = $data['due_date'];
                            $borrowedBook->user_id = auth()->id();
                            $borrowedBook->type_request = borrow_requests::type_request1;

                            $borrowedBook->save();

                            Notification::make()
                                ->title('Send Request Successfuly')

                                ->success()
                                ->send();

                        }

                    })
                    ->form([
                        Forms\Components\DatePicker::make('due_date')->nullable()->minDate(now()->format('Y-m-d')),
                    ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),

                ]),

            ]);

    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                SectionInfoList::make('Book')
                    ->icon('heroicon-m-book-open')
                    ->iconColor('primary')
                    ->schema([
                        TextEntry::make('title')
                            ->color('secondry')
                            ->weight(FontWeight::Bold),
                        TextEntry::make('status')->formatStateUsing(function (string $state): string {
                            if ($state == 1) {
                                return 'Available';
                            } else {
                                return 'Issued';
                            }
                        })->badge()
                            ->color(fn(string $state): string => match ($state) {
                                '1' => 'success', // Change '1' to the value representing 'Available'
                                '0' => 'warning', // Change '2' to the value representing 'Issued'
                            }),
                    ])->columns(2),
                SectionInfoList::make('Book Description')
                    ->icon('heroicon-m-book-open')
                    ->compact()
                    ->iconColor('primary')
                    ->schema([
                        TextEntry::make('description')->formatStateUsing(function (string $state) {
                            return Str::of(strip_tags($state))->toString();
                        })
                            ->color('secondry'),

                    ]),
                SectionInfoList::make('Book Details')
                    ->icon('heroicon-m-book-open')
                    ->compact()
                    ->iconColor('primary')
                    ->schema([
                        ImageEntry::make('image')
                            ->width(130)
                            ->height(200),
                        TextEntry::make('pages')
                            ->color('secondry'),
                        TextEntry::make('category.name')
                            ->color('secondry'),
                        TextEntry::make('author')
                            ->color('secondry'),
                        TextEntry::make('publisher')
                            ->color('secondry'),

                    ])->columns(5),

            ]);
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
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