<?php

namespace App\Models\Artist;

use App\Models\Album\Album;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $guarded = [];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
