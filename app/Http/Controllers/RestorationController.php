<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestorationRequest;
use Illuminate\Http\Request;
use App\Services\RestorationService;
use App\Http\Resources\RestorationResource;
use App\Models\Lending;

class RestorationController extends Controller
{
    private $restorationService;

    public function __construct(RestorationService $restorationService)
    {
        $this->restorationService = $restorationService;
    }

    public function index()
    {
        try {
            $restoration = $this->restorationService->index();
            return response()->json(RestorationResource::collection($restoration), 200);
        } catch (\Exception $err) {
            return response()->json($err->getMessage(), 400);
        }
    }

    public function restore(Request $request)
    {
        try {
            $paylod = RestorationRequest::validate($request);
            $lending = Lending::where('id', $paylod['lending_id'])->first();
            if ($lending->total_stuff < $paylod['total_good_stuff'] + $paylod['total_defec_stuff']) {
                return response()->json(['error' => 'Jumlah barang yang dikembalikan lebih dari yang dipinjam!'], 400);
            }
            if ($lending->total_stuff > $paylod['total_good_stuff'] + $paylod['total_defec_stuff']) {
                return response()->json(['error' => 'Jumlah barang yang dikembalikan kurang dari yang dipinjam!'], 400);
            }
            if ($this->restorationService->payload($paylod)) {
                $restoration = $this->restorationService->store($paylod);
                return response()->json([
                    'data' => new RestorationResource($restoration),
                    'message' => 'Berhasil menambahkan data'
                ], 200);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 400);
        }
    }
}
