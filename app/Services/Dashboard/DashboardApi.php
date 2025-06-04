<?php

namespace App\Services\Dashboard;

use App\Models\Album\Album;
use App\Models\Artist\Artist;

class DashboardApi 
{
    protected $album;
    protected $artist;

    public function __construct(
        Album $album,
        Artist $artist
    ) 
    {
        $this->album  = $album;
        $this->artist = $artist;
    }

    public function totalNumberOfAlbumsSoldPerArtist()
    {
        $artists = $this->artist
            ->select('id', 'code', 'name')
            ->withCount('albums')
            ->paginate(10);

        $artists->getCollection()->transform(function ($artist) {
            $artist->albums_sold = $artist->albums_count;
            unset($artist->albums_count);
            return $artist;
        });

        return $artists;
    }

    public function combinedAlbumSales()
    {
        $artists = $this->artist
            ->select('id', 'code', 'name')
            ->withSum('albums', 'sales')
            ->paginate(10);

        $artists->getCollection()->transform(function ($artist) {
            $artist->combined_sales = $artist->albums_sum_sales;
            unset($artist->albums_sum_sales);
            return $artist;
        });

        return $artists;
    }

    public function topOneArtist()
    {
        $artist = $this->artist
            ->select('id', 'code', 'name')
            ->withSum('albums', 'sales')
            ->orderByDesc('albums_sum_sales') 
            ->first();

            if ($artist) {
                $artist->most_combined_sales = $artist->albums_sum_sales;
                unset($artist->albums_sum_sales);
            }

        return $artist;
    }

    public function searchArtist($request)
    {
        $search = $request->search;

        return $this->album
            ->select('id', 'name', 'image', 'year', 'sales')
            ->whereHas('artist', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10);
    }
}