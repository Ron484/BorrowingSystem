<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\borrow_requests;
use App\Models\borrowingBooks;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class StatsSystemOverview extends BaseWidget
{

    

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::query()->count())
                ->description('All users of Borrowing System')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Total Books', Book::query()->count())
                ->description('All books in the library')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('secondry'),
            Stat::make('Available Books', Book::availableBooksCount())
                ->description('All available books to borrow')
                ->descriptionIcon('heroicon-m-bookmark')
                ->color('primary'),
            Stat::make('Borrowed Books', Book::borrowedBooksCount())
                ->description('All borrowed books')
                ->descriptionIcon('heroicon-m-bookmark-slash')
                ->color('secondry'),
            Stat::make('Returned Books', borrowingBooks::returnedBooksCount())
                ->description('All returend books')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('primary'),
            Stat::make('Total Requests', borrow_requests::query()->count())
                ->description('All sent requests to the system')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('secondry'),
        ];
    }
}

