<?php

namespace App\Filament\Resources\PreviouslyBorrowedBooksResource\Pages;

use App\Filament\Resources\PreviouslyBorrowedBooksResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePreviouslyBorrowedBooks extends CreateRecord
{
    protected static string $resource = PreviouslyBorrowedBooksResource::class;
}
