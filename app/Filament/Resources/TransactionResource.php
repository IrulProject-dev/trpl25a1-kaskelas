<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $pluralModelLabel = 'Transaksi';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                ->relationship('category', 'name') 
                ->required(),
                TextInput::make('description')
                ->required()
                ->maxLength(255),
                TextInput::make('amount')
                ->numeric()
                ->prefix('Rp')
                ->required(),
                Select::make('type')
                ->options([
                    'income' => 'Pemasukan',
                    'expense' => 'Pengeluaran',
                ])
                ->required(),
                DatePicker::make('transaction_date')
                ->default(now())
                ->required(),
                Hidden::make('user_id')
                ->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction_date')
                ->date('d M Y')
                ->sortable(),
                TextColumn::make('category.name')
                ->label('Kategori'),
                TextColumn::make('description')
                ->label('Keterangan')
                ->limit(30),
                TextColumn::make('type')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'income' => 'success',
                    'expense' => 'danger',
                }),
                TextColumn::make('amount')
                ->money('IDR')
                ->label('Jumlah'),
            ])
            ->defaultSort('transaction_date', 'desc')

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
