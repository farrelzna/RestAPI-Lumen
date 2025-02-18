<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestorationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            // "stuff" => $this->stuff ,
            "lending" => $this->lending,
            "user" => $this->user,
            "date_time" => $this->date_time,
            "total_good_stuff" => $this->total_good_stuff,
            "total_defec_stuff" => $this->total_defec_stuff,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at
        ];
    }
}
