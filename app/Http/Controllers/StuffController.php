<?php

namespace App\Http\Controllers;

use App\Http\Requests\StuffRequest;
use App\Http\Resources\StuffResource;
use App\Services\StuffService;
use Illuminate\Http\Request;

class StuffController extends Controller
{
    private $stuffService;

    public function __construct(StuffService $stuffService)
    {
        $this->stuffService = $stuffService;
    }

    public function index ()
    {
        try {
            $stuffs = $this->stuffService->index();
            // response ()->json : hasil yang akan dimunculkan ketika mengakses url terkait : json {data yang mau dimunculin, https status code}
            return response()->json(StuffResource::collection($stuffs), 200);
        } catch (\Exception $err) {
            // jika try ada yang error, munculkan response berupa desk err dan statusnya 400
            return response()->json($err->getMessage(), 400);
        }
    }

    public function store (Request $request)
    {
        try {
            $payload = StuffRequest::validate($request);
            $stuff = $this->stuffService->store($payload);
            return response()->json(new StuffResource($stuff), 200);
        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => $err->getMessage()
            ], 400);
        }    
    }

    public function show ($id)
    {
        try {
            // Ambil data menggunakan service
            $stuff = $this->stuffService->show($id);
    
            if ($stuff) {
                // Jika data ditemukan, kembalikan response dengan resource
                return response()->json([
                    'success' => true,
                    'data' => new StuffResource($stuff)
                ], 200);
            } else {
                // Jika data tidak ditemukan
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }
        } catch (\Exception $err) {
            // Tangkap exception dan kembalikan error message
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $err->getMessage()
            ], 500);
        }
    }

    public function update (Request $request, $id)
    {
        try {
            $payload = StuffRequest::validate($request);
            $stuff = $this->stuffService->update($payload, $id);
            return response()->json(new StuffResource($stuff), 200);
        } catch (\Exception $err) {
            return response()->json($err->getMessage(), 400);
        }
    }

    public function trash()
    {
        try {
            $stuffs = $this->stuffService->trash();
            return response()->json(StuffResource::collection($stuffs), 200);
        } catch (\Exception $err) {
            return response()->json($err->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        try {
            $stuff = $this->stuffService->destroy($id);
            return response()->json(new StuffResource($stuff), 200);
        } catch (\Exception $err) {
            return response()->json($err->getMessage(), 400);
        }   
    }

    public function restore($id)
    {
        try {
            $stuff = $this->stuffService->restore($id);
            return response()->json(new StuffResource($stuff), 200);
        } catch (\Exception $err){
            return response()->json($err->getMessage(), 400);
        }
    }

    public function permanentDelete($id)
    {
        try {
            $delete = $this->stuffService->permanentDelete($id);
            return response()->json("deleted", 200);
        } catch (\Exception $err) {
            return response()->json($err->getMessage(), 400);
        }
    }
}