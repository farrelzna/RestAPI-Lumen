<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// mengatur respon data yang akan dikirimkan ke client

class StuffResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => strtoupper($this->type),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}