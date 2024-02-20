<?php

namespace App\Filament\Resources\CurrentlyBorrowedBooksResource\Pages;

use App\Filament\Resources\CurrentlyBorrowedBooksResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurrentlyBorrowedBooks extends EditRecord
{
    protected static string $resource = CurrentlyBorrowedBooksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
