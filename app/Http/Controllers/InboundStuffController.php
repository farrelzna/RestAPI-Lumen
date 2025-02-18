<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StuffStockService;
use App\Services\InboundStuffService;
use App\Http\Requests\InboundStuffRequest;
use App\Http\Resources\InboundStuffResource;

class InboundStuffController extends Controller
{
    private $inboundStuffService, $StuffStockService;

    public function __construct(InboundStuffService $inboundStuffService, StuffStockService $StuffStockService)
    {
        $this->inboundStuffService = $inboundStuffService;
        $this->StuffStockService = $StuffStockService;
    }

    public function index()
    {
        try {
            $inboundStuff = $this->inboundStuffService->index();
            // response ()->json : hasil yang akan dimunculkan ketika mengakses url terkait : json {data yang mau dimunculin, https status code}
            return response()->json(InboundStuffResource::collection($inboundStuff), 200);
        } catch (\Exception $err) {
            // jika try ada yang error, munculkan response berupa desk err dan statusnya 400
            return response()->json($err->getMessage(), 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $payload = InboundStuffRequest::validate($request);
            $inboundStuff = $this->inboundStuffService->store($request);
            $stuffStock = $this->StuffStockService->update($payload);
            return response()->json(new InboundStuffResource($inboundStuff), 200);
        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => $err->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $inboundStuff = $this->inboundStuffService->destroy($id);
            return response()->json(new InboundStuffResource($inboundStuff), 200);
        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => $err->getMessage()
            ], 400);
        }
    }
}
