<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\ResourceCollection;

// format dari resource

class UserColection extends ResourceCollection
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}