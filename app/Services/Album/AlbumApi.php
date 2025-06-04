<?php

namespace App\Services\Album;

use App\Models\Album\Album;

class AlbumApi 
{
    protected $album;

    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    public function getAllAlbums($request)
    {
        $perPage = $request->get('per_page', 10); 

        return $this->album->paginate($perPage);
    }

    public function createAlbum($request) 
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('albums', 'public');
        }

        return $this->album->create([
            'artist_id' => $request->artist_id,
            'name'      => $request->name,
            'year'      => $request->year,
            'sales'     => $request->sales,
            'image'     => $imagePath
        ]);

    }

    public function updateAlbum($request, $id)
    {
        $album = $this->album->findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('albums', 'public');
            $album->image = $imagePath;
        } 

        $album->update([
            'artist_id' => $request->artist_id,
            'name'      => $request->name,
            'year'      => $request->year,
            'sales'     => $request->sales,
        ]);

        return $album;
    }

    public function deleteAlbum($id)
    {
        return $this->album->findOrFail($id)->delete();
    }
}