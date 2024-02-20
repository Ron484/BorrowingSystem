<?php

namespace App\Filament\Resources;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\pages;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manage Users';

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live()
                    ->maxLength(250),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(250),
                Forms\Components\Select::make('role')->label('User Role')
                    ->required()
                    ->columnSpanFull()
                    ->options([
                        User::user => 'User',
                        User::admin => 'Admin',
                    ])->columns(4)->native(false),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                    ->required(),

            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone_number')->label('Phone number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state) : string => match ($state) {
                        'USER' => 'success',
                        'ADMIN' => 'warning',
                    }),

            ])
            ->filters([
                Filter::make('role')
                    ->query(function ($query) {
                        $query->where('role', User::admin);
                    })
                    ->label('Is admin'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}