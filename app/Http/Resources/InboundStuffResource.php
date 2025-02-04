<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InboundStuffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->stuff->makeHidden(['stuff_stock']);
        return [
            'id' => $this->id,
            'stuff' => $this->stuff,
            'stuff_stock' => $this->stuff->stuffStock,
            'total' => $this->total,
            'date' => $this->date,
            'proof_file' => $this->proof_file,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}