<?php

namespace App\Filament\Resources\CurrentlyBorrowedBooksResource\Pages;

use App\Filament\Resources\CurrentlyBorrowedBooksResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCurrentlyBorrowedBooks extends CreateRecord
{
    protected static string $resource = CurrentlyBorrowedBooksResource::class;
}
