<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    use HasFactory;

    protected $table = "credit_debit_user_amounts";

    public function user()
    {
        return $this->hasOne(ClientUser::class,'id','user_id');
    }
}
