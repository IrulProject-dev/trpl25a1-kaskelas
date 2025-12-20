<?php

namespace App\Filament\Resources\TransactionMemberResource\Pages;

use App\Filament\Resources\TransactionMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionMember extends EditRecord
{
    protected static string $resource = TransactionMemberResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
