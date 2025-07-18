<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laughterhow extends Model
{
    use HasFactory;

    protected $table = 'laughter_show';

    use SoftDeletes;   
    
    public function networks(){
        return $this->belongsToMany(ContentNetwork::class, 'laugter_show_content_network', 'movie_id', 'network_id');
    }
}
