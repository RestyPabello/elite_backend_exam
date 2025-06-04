<?php

namespace Database\Seeders;

use App\Models\Artist\Artist;
use App\Models\Album\Album;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artists = json_decode(File::get(database_path('data/artists.json')), true);

        foreach ($artists as $artistData) {
            $artists = Artist::create([
                "code" => $artistData["code"],
                "name" => $artistData["name"]
            ]);

            $artists->albums()->createMany($artistData["album"]);
        }
    }
}
