<?php

namespace App\Services\Artist;

use App\Models\Artist\Artist;

class ArtistApi 
{
    protected $artist;

    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
    }

    public function getAllArtists($request)
    {   
        $perPage = $request->get('per_page', 10); 

        return $this->artist->paginate($perPage);
    }

    public function createArtist($request) 
    {
       return $this->artist->create([
            'code' => $this->generateCode(),
            'name' => $request->name
       ]);
    }

    public function updateArtist($request, $id)
    {
        $artist = $this->artist->findOrFail($id);
        $artist->update(['name' => $request->name]);

        return $artist;
    }

    public function deleteArtist($id)
    {
        return $this->artist->findOrFail($id)->delete();
    }

    private function generateCode()
    {
        $lastArtistCode  = $this->artist->select('code')->latest('id')->first();
        $checkArtistCode = $lastArtistCode ? $lastArtistCode->code : '0000000';
        $lastCode        = intval($checkArtistCode) + 1;
        $newArtistCode   = str_pad($lastCode, 7, '0', STR_PAD_LEFT);

        return $newArtistCode;
    }
}