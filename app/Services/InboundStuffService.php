<?php

namespace App\Services;

use App\Repositories\InboundStuffRepositories;
use Illuminate\Http\Response;
use Carbon\Carbon;

class InboundStuffService
{
    private $inboundStuffRepositories;
    
    public function __construct(InboundStuffRepositories $inboundStuffRepositories)
    {
        $this->inboundStuffRepositories = $inboundStuffRepositories;
    }

    public function store($data)
    {
        if ($data->file('proof_file')) {
            $imageLink = $this->inboundStuffRepositories->uploadImage($data->file('proof_file'));
        }

        $inboundStuff = [
            'stuff_id' => $data->stuff_id,
            'total' => $data->total,
            'date' => Carbon::now(),
            'proof_file' => $imageLink,
        ];

        $store =
            $this->inboundStuffRepositories->storeInbound($inboundStuff);
        return $store;
    }
    
    public function destroy($id)
    {
        return $this->inboundStuffRepositories->deleteInboundStuff($id);
    }
}