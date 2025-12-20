<?php

namespace App\Filament\Resources\TransactionMemberResource\Pages;

use App\Filament\Resources\TransactionMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransactionMember extends CreateRecord
{
    protected static string $resource = TransactionMemberResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string
    {
        return 'Tambah Transaksi Anggota';
    }
}
