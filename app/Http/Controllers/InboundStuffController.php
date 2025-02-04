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

    public function destroy ($id)
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
