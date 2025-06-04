<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Artist\ArtistRequest;
use App\Http\Resources\Artist\ArtistResource;
use App\Services\Artist\ArtistApi;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    protected $artistApi;
    
    public function __construct(ArtistApi $artistApi)
    {
        $this->artistApi = $artistApi;
    }

    public function index(Request $request)
    {
        try {
            $result = $this->artistApi->getAllArtists($request);

            return response()->json([
                'status_code' => 200,
                'message'     => 'Successful',
                'data'        => ArtistResource::collection($result),
                'pagination'  => [
                    'current_page'   => $result->currentPage(),
                    'last_page'      => $result->lastPage(),
                    'per_page'       => $result->perPage(),
                    'total'          => $result->total(),
                    'next_page_url'  => $result->nextPageUrl(),
                    'prev_page_url'  => $result->previousPageUrl(),
                    'path'           => $result->path(),
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status_code' => 400,
                    'message'     => $e->getMessage(),
                ],
                400
            );
        }
    }

    public function store(ArtistRequest $request) 
    {
        try {
            $result = $this->artistApi->createArtist($request);

            return response()->json([
                'status_code' => 200,
                'message'     => 'The artist has been successfully created',
                'data'        => new ArtistResource($result)
            ]);
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status_code' => 400,
                    'message'     => $e->getMessage(),
                ],
                400
            );
        }
    }

    public function update(ArtistRequest $request, $id)
    {
        try {
            $result = $this->artistApi->updateArtist($request, $id);

            return response()->json([
                'status_code' => 200,
                'message'     => 'The artist has been successfully updated',
                'data'        => new ArtistResource($result)
            ]);
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status_code' => 400,
                    'message'     => $e->getMessage(),
                ],
                400
            );
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->artistApi->deleteArtist($id);

            return response()->json([
                'status_code' => 200,
                'message'     => 'The artist has been successfully deleted',
            ]);
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status_code' => 400,
                    'message'     => $e->getMessage(),
                ],
                400
            );
        }
    }
}
