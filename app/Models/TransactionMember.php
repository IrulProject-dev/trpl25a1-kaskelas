<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionMember extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $table = 'transaction_members';
    protected $fillable = ['member_id', 'week_id', 'amount'];

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function week() {
        return $this->belongsTo(Week::class);
    }

    public function getPaymentStatusAttribute() {
        if (!$this->week) {
            return 'unknown';
        }

        if ($this->amount >= $this->week->nominal) {
            return 'paid'; // Lunas
        } elseif ($this->amount > 0) {
            return 'partial'; // Bayar sebagian
        } else {
            return 'unpaid'; // Belum bayar
        }
    }

    public function getPaymentStatusColor() {
        $status = $this->getPaymentStatusAttribute();

        switch ($status) {
            case 'paid':
                return 'success'; // Hijau untuk lunas
            case 'partial':
                return 'warning'; // Kuning untuk bayar sebagian
            case 'unpaid':
                return 'danger'; // Merah untuk belum bayar
            default:
                return 'gray'; // Abu-abu untuk status tidak diketahui
        }
    }

    public function isPaid() {
        return $this->amount >= ($this->week->nominal ?? 0);
    }

    public function isPartiallyPaid() {
        return $this->amount > 0 && $this->amount < ($this->week->nominal ?? 0);
    }

    public function isUnpaid() {
        return $this->amount == 0 || $this->amount < ($this->week->nominal ?? 0);
    }
}