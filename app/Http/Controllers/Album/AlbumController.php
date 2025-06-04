<?php

namespace App\Http\Controllers\Album;

use App\Http\Controllers\Controller;
use App\Http\Requests\Album\AlbumRequest;
use App\Http\Resources\Album\AlbumResource;
use App\Services\Album\AlbumApi;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    protected $albumApi;

    public function __construct(AlbumApi $albumApi)
    {
        $this->albumApi = $albumApi;
    }

    public function index(Request $request) 
    {

        try {
            $result = $this->albumApi->getAllAlbums($request);

            return response()->json([
                'status_code' => 200,
                'message'     => 'Successful',
                'data'        => AlbumResource::collection($result),
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

    public function store(AlbumRequest $request)
    {
        try {
            $result = $this->albumApi->createAlbum($request);

            return response()->json([
                'status_code' => 200,
                'message'     => 'The album has been successfully created',
                'data'        => new AlbumResource($result)
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

    public function update(AlbumRequest $request, $id)
    {
        try {
            $result = $this->albumApi->updateAlbum($request, $id);

            return response()->json([
                'status_code' => 200,
                'message'     => 'The album has been successfully updated',
                'data'        => new AlbumResource($result)
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
            $result = $this->albumApi->deleteAlbum($id);

            return response()->json([
                'status_code' => 200,
                'message'     => 'The album has been successfully deleted',
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
