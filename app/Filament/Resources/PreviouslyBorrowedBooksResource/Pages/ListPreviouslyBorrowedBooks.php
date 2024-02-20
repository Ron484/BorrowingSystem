<?php

namespace App\Filament\Resources\PreviouslyBorrowedBooksResource\Pages;

use App\Filament\Resources\PreviouslyBorrowedBooksResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPreviouslyBorrowedBooks extends ListRecords
{
    protected static string $resource = PreviouslyBorrowedBooksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
