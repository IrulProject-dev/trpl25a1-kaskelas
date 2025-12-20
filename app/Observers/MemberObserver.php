<?php

namespace App\Observers;

use App\Models\Member;
use App\Models\TransactionMember;
use App\Models\Week;

class MemberObserver
{
    /**
     * Handle the Member "created" event.
     */
    public function created(Member $member): void
    {
        $weeks = Week::all();

        foreach ($weeks as $week) {
            TransactionMember::create([
                'member_id' => $member->id,
                'week_id' => $week->id,
                'amount' => 0 // Default 0
            ]);
        }
    }

    /**
     * Handle the Member "updated" event.
     */
    public function updated(Member $member): void
    {
        //
    }

    /**
     * Handle the Member "deleted" event.
     */
    public function deleted(Member $member): void
    {
        //
    }

    /**
     * Handle the Member "restored" event.
     */
    public function restored(Member $member): void
    {
        //
    }

    /**
     * Handle the Member "force deleted" event.
     */
    public function forceDeleted(Member $member): void
    {
        //
    }
}
