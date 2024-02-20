<?php

namespace App\Filament\Resources\PreviouslyBorrowedBooksResource\Pages;

use App\Filament\Resources\PreviouslyBorrowedBooksResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPreviouslyBorrowedBooks extends EditRecord
{
    protected static string $resource = PreviouslyBorrowedBooksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
