<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminWallet extends Model
{
    use HasFactory;

    protected $table = "credit_debit_admin_amounts";

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
