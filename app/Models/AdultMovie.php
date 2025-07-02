<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdultMovie extends Model
{
    use HasFactory;

    protected $table = 'adult_movies';

    use SoftDeletes;

    public function genres(){
        return $this->belongsToMany(Genre::class, 'movie_genres', 'movie_id', 'genre_id');
    }
    public function networks(){
        return $this->belongsToMany(ContentNetwork::class, 'adult_movie_content_network', 'movie_id', 'network_id');
    }
}
