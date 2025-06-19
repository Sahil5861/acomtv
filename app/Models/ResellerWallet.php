<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResellerWallet extends Model
{
    use HasFactory;

    protected $table = "credit_debit_reseller_amounts";
    public function user()
    {
        return $this->hasOne(ClientUser::class,'id','user_id');
    }
}
