<?php

namespace App\Http\Controllers;

use App\Http\Requests\LendingRequest;
use Illuminate\Http\Request;
use App\Services\LendingService;
use App\Http\Resources\LendingResource;
use App\Models\Lending;

class LendingController extends Controller
{
    private $lendingService;
    public function __construct(LendingService $lendingService)
    {
        $this->lendingService = $lendingService;
    }

    public function index()
    {
        try {
            $lending = $this->lendingService->index();
            // response ()->json : hasil yang akan dimunculkan ketika mengakses url terkait : json {data yang mau dimunculin, https status code}
            return response()->json(LendingResource::collection($lending), 200);
        } catch (\Exception $err) {
            // jika try ada yang error, munculkan response berupa desk err dan statusnya 400
            return response()->json($err->getMessage(), 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $payload = LendingRequest::validate($request);

            $checkStock = $this->lendingService->check($payload);
            if (is_null($checkStock)) {
                $lending = $this->lendingService->store($payload);
                return response()->json(new LendingResource($lending), 200);
            }
        } catch (\Exception $err) {
            return response()->json($err->getMessage(), 400);
        }
    }
}
