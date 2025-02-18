<?php

namespace App\Http\Resources;

use illuminate\Http\Resources\Json\ResourceCollection;

class LendingCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
