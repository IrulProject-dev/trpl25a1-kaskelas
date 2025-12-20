<?php

namespace App\Filament\Resources\TransactionMemberResource\Pages;

use App\Filament\Resources\TransactionMemberResource;
use App\Models\Member;
use App\Models\TransactionMember;
use App\Models\Week;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Livewire\Attributes\Computed;

class KasRekap extends Page
{
    protected static string $resource = TransactionMemberResource::class;
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Rekap Kas Excel';
    protected static ?string $title = 'Rekap Kas Bulanan';
    protected static string $view = 'filament.resources.transaction-member-resource.pages.kas-rekap';

    public $months = [];
    public $members;

    // Store current values for modal
    public $currentMemberId = null;
    public $currentWeekId = null;
    public $currentAmount = 0;
    public $showEditModal = false;

    protected function getHeaderActions(): array
    {
        $currentAmount = $this->currentAmount; // Capture current amount to pass to form
        return [
            Action::make('editBayar')
                ->label('Input Kas')
                ->modalWidth('sm')
                ->form([
                    TextInput::make('amount')
                        ->label('Nominal (Rp)')
                        ->numeric()
                        ->required()
                        ->default($currentAmount)
                        ->autofocus()
                        ->prefix('Rp'),
                ])
                ->action(function (array $data) {
                    // Check if required data exists
                    if (!$this->currentMemberId || !$this->currentWeekId) {
                        Notification::make()
                            ->title('Error')
                            ->body('Gagal menyimpan: Data tidak lengkap')
                            ->danger()
                            ->send();
                        return;
                    }

                    TransactionMember::updateOrCreate(
                        [
                            'member_id' => $this->currentMemberId,
                            'week_id' => $this->currentWeekId,
                        ],
                        ['amount' => $data['amount']]
                    );

                    Notification::make()->title('Disimpan')->success()->send();

                    // Reset values
                    $this->currentMemberId = null;
                    $this->currentWeekId = null;
                    $this->currentAmount = 0;
                    $this->showEditModal = false;

                    // Refresh halaman agar data terbaru tampil
                    $this->redirect($this->getUrl());
                }),
        ];
    }

    public function mount()
    {
        $this->members = Member::with('transaction_members')->orderBy('nim')->get();

        $weeks = Week::orderBy('start_date')->get();

        foreach ($weeks as $week) {
            $monthName = Carbon::parse($week->start_date)->translatedFormat('F Y'); // Contoh: Oktober 2024
            $this->months[$monthName][] = $week;
        }
    }

    protected function getViewData(): array
    {
        return [
            'months' => $this->months,
            'members' => $this->members,
        ];
    }

    public function openInput($memberId, $weekId, $currentAmount, $nominalWajib)
    {
        $this->currentMemberId = $memberId;
        $this->currentWeekId = $weekId;
        $this->currentAmount = $currentAmount;
        $this->mountAction('editBayar');
    }
}
