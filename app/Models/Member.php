<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable = ['nim', 'name', 'batch'];

    public function transaction_members()
    {
        return $this->hasMany(TransactionMember::class);
    }
}
