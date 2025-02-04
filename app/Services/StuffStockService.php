<?php

namespace App\Services;

use App\Repositories\StuffStockRepositories;

class StuffStockService
{
    private $stuffStockRepositories;
    
    public function __construct (StuffStockRepositories $stuffStockRepositories)
    {
        $this->stuffStockRepositories = $stuffStockRepositories;
    }
    public function update (array $data) 
    {
        return $this->stuffStockRepositories->update($data);
    }
}