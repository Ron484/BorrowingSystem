<?php

namespace App\Filament\Resources\BorrowRequestsResource\Pages;

use App\Filament\Resources\BorrowRequestsResource;
use App\Models\borrow_requests;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListBorrowRequests extends ListRecords
{
    protected static string $resource = BorrowRequestsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];

    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'borrowRequests' => Tab::make('Borrow requests')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('type_request', borrow_requests::type_request1);
                }),
            'returnRequests' => Tab::make('Return requests')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('type_request', borrow_requests::type_request2);
                }),

        ];
    }

}