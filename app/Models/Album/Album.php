<?php

namespace App\Models\Album;

use App\Models\Artist\Artist;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $guarded = [];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
