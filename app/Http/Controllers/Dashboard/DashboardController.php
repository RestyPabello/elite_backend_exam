<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardApi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardApi;

    public function __construct(DashboardApi $dashboardApi)
    {
        $this->dashboardApi = $dashboardApi;
    }

    public function totalNumbers()
    {
         try {
            $result = $this->dashboardApi->totalNumberOfAlbumsSoldPerArtist();

            return response()->json([
                'status_code' => 200,
                'message'     => 'Successful',
                'data'        => $result
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

    public function combinedAlbums()
    {
        try {
            $result = $this->dashboardApi->combinedAlbumSales();

            return response()->json([
                'status_code' => 200,
                'message'     => 'Successful',
                'data'        => $result
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

    public function topOneArtist()
    {
        try {
            $result = $this->dashboardApi->topOneArtist();

            return response()->json([
                'status_code' => 200,
                'message'     => 'Successful',
                'data'        => $result
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

    public function searchArtist(Request $request)
    {   
        try {
            $result = $this->dashboardApi->searchArtist($request);

            return response()->json([
                'status_code' => 200,
                'message'     => 'Successful',
                'data'        => $result
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
