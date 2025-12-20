<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable = ['name', 'nominal', 'start_date'];

    public function transaction_members()
    {
        return $this->hasMany(TransactionMember::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'transaction_members')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function getPaymentStatus()
    {
        $totalMembers = $this->getTotalMembersCount();
        $paidMembers = $this->getPaidMembersCount();
        $unpaidMemberCount = $totalMembers - $paidMembers;

        if ($totalMembers == 0) {
            return 'Tidak ada anggota';
        }

        $percentage = $totalMembers > 0 ? ($paidMembers / $totalMembers) * 100 : 0;

        if ($percentage == 100) {
            return 'Lunas (100%)';
        } elseif ($percentage == 0) {
            return 'Belum Bayar (0%)';
        } else {
            return "Terbayar: {$paidMembers}/{$totalMembers} (Tunggak: {$unpaidMemberCount})";
        }
    }

    public function getPaymentStatusColor()
    {
        $totalMembers = $this->getTotalMembersCount();
        if ($totalMembers == 0) {
            return 'gray';
        }

        $paidMembers = $this->getPaidMembersCount();
        $percentage = ($paidMembers / $totalMembers) * 100;

        if ($percentage == 100) {
            return 'success'; // Hijau untuk lunas
        } elseif ($percentage == 0) {
            return 'danger'; // Merah untuk belum bayar
        } else {
            return 'warning'; // Kuning/orange untuk sebagian bayar
        }
    }

    public function getPaidMembersCount()
    {
        // Dapatkan semua member yang memiliki transaksi >= nominal
        $paidMembers = $this->transaction_members()
            ->where('amount', '>=', $this->nominal)
            ->pluck('member_id');

        return $paidMembers->count();
    }

    public function getTotalMembersCount()
    {
        return \App\Models\Member::count();
    }

    public function getUnpaidMembersList()
    {
        $allMembers = \App\Models\Member::pluck('id');
        $paidMembers = $this->transaction_members()
            ->where('amount', '>=', $this->nominal)
            ->pluck('member_id');

        // Dapatkan ID anggota yang belum bayar
        $unpaidMemberIds = $allMembers->diff($paidMembers);

        if ($unpaidMemberIds->count() === 0) {
            return 'Semua anggota sudah membayar';
        }

        // Dapatkan nama anggota yang belum bayar
        $unpaidMembers = \App\Models\Member::whereIn('id', $unpaidMemberIds)->pluck('name');
        return 'Belum bayar: ' . $unpaidMembers->join(', ');
    }

    public function getUnpaidMemberIds()
    {
        $allMemberIds = \App\Models\Member::pluck('id');
        $paidMemberIds = $this->transaction_members()
            ->where('amount', '>=', $this->nominal)
            ->pluck('member_id');

        return $allMemberIds->diff($paidMemberIds);
    }

    public function getUnpaidMembers()
    {
        $unpaidIds = $this->getUnpaidMemberIds();
        return \App\Models\Member::whereIn('id', $unpaidIds)->get();
    }
}
