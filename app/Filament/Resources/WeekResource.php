<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeekResource\Pages;
use App\Filament\Resources\WeekResource\RelationManagers;
use App\Models\Week;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WeekResource extends Resource
{
    protected static ?string $model = Week::class;

    protected static ?string $navigationLabel = 'Minggu';

    protected static ?string $pluralModelLabel = 'Minggu';

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('Nama Minggu')
                ->required()
                ->maxLength(255),

                DatePicker::make('start_date')
                ->label('Tanggal Mulai')
                ->required(),

                TextInput::make('nominal')
                ->label('Tagihan Wajib')
                ->numeric()
                ->prefix('Rp')
                ->minValue(0)
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('Nama Minggu')
                ->searchable()
                ->description(fn (Week $record) => $record->getUnpaidMembersList())
                ->color(fn (Week $record) => $record->getPaymentStatusColor()),

                TextColumn::make('start_date')
                ->date('d M Y')
                ->label('Tanggal Mulai')
                ->sortable(),

                TextInputColumn::make('nominal')
                ->type('number')
                ->rules(['required', 'numeric', 'min:0'])
                ->label('Tagihan Wajib'),

                TextColumn::make('payment_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn (Week $record) => $record->getPaymentStatus())
                    ->color(fn (Week $record) => $record->getPaymentStatusColor()),
            ])
            ->defaultSort('start_date', 'desc')
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
            'index' => Pages\ListWeeks::route('/'),
            'create' => Pages\CreateWeek::route('/create'),
            'edit' => Pages\EditWeek::route('/{record}/edit'),
        ];
    }
}
