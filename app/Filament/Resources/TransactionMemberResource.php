<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionMemberResource\Pages;
use App\Filament\Resources\TransactionMemberResource\RelationManagers;
use App\Models\TransactionMember;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;

class TransactionMemberResource extends Resource
{
    protected static ?string $model = TransactionMember::class;

    protected static ?string $navigationLabel = 'Transaksi Anggota';

    protected static ?string $pluralModelLabel = 'Transaksi Anggota';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('member_id')
                    ->relationship('member', 'name')
                    ->searchable()
                    ->required(),
                Select::make('week_id')
                    ->relationship('week', 'name')
                    ->searchable()
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->minValue(0),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.name')
                ->label('Mahasiswa')
                ->description(fn ($record) => $record->member->nim)
                ->searchable()
                ->sortable(),

                TextColumn::make('week.name')
                ->label('Minggu')
                ->badge(),

                TextInputColumn::make('amount')
                ->label('Nominal Masuk')
                ->type('number')
                ->rules(['required', 'numeric', 'min:0'])
                ->step(500)
                ->color(fn (TransactionMember $record) => $record->getPaymentStatusColor())
                ->extraAttributes(function (TransactionMember $record) {
                    return [
                        'class' => match($record->getPaymentStatusAttribute()) {
                            'paid' => 'bg-success-50 dark:bg-success-900/20',
                            'partial' => 'bg-warning-50 dark:bg-warning-900/20',
                            'unpaid' => 'bg-danger-50 dark:bg-danger-900/20',
                            default => ''
                        }
                    ];
                })
                ->afterStateUpdated(function ($record, $state) {
                    // Opsional: Kode ini jalan otomatis setelah admin selesai ngetik & tekan enter
                    // Berguna jika mau kirim notifikasi atau log
                }),

                TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (TransactionMember $record) => match($record->getPaymentStatusAttribute()) {
                        'paid' => 'Lunas',
                        'partial' => 'Sebagian',
                        'unpaid' => 'Belum Bayar',
                        default => 'Tidak Diketahui'
                    })
                    ->color(fn (TransactionMember $record) => $record->getPaymentStatusColor()),

                TextColumn::make('updated_at')
                ->dateTime('d/m H:i')
                ->label('Waktu Input')
                ->color('gray'),

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('tahun')
                ->form([
                    Forms\Components\Select::make('year')
                        ->label('Tahun')
                        ->options([
                            2024 => '2024',
                            2025 => '2025',
                            2026 => '2026',
                        ])
                        ->default(now()->year),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query->when(
                        $data['year'],
                        // Filter berdasarkan relasi week -> start_date
                        fn (Builder $query, $year) => $query->whereHas('week', function ($q) use ($year) {
                            $q->whereYear('start_date', $year);
                        })
                    );
                }),

            SelectFilter::make('week_id')->relationship('week', 'name')->searchable(),
            SelectFilter::make('member_id')->relationship('member', 'name')->searchable(),
            ])
            ->actions([
                // Menghilangkan tombol edit karena fungsionalitas input sekarang di halaman KasRekap
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
            'index' => Pages\KasRekap::route('/'),
            'create' => Pages\CreateTransactionMember::route('/create'),
            'edit' => Pages\EditTransactionMember::route('/{record}/edit'),
            'list' => Pages\ListTransactionMembers::route('/list'),
        ];
    }
}
