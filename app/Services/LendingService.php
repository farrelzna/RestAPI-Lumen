<?php

namespace App\Services;

use App\Repositories\LendingRepositories;
use Carbon\Carbon;
use illuminate\Support\Facades\Auth;

class LendingService
{
    private $lendingRepositories;
    public function __construct(LendingRepositories $lendingRepositories)
    {
        $this->lendingRepositories = $lendingRepositories;
    }

    public function index()
    {
        return $this->lendingRepositories->getAllLending();
    }

    public function check(array $data)
    {
        return $this->lendingRepositories->checkStock($data);
    }

    public function store(array $data)
    {
        $payload = [
            "stuff_id" => $data['stuff_id'],
            "date_time" => Carbon::now(),
            "name" => $data['name'],
            "user_id" => Auth::user()->id,
            "notes" => $data['notes'] ?? NULL,
            "total_stuff" => $data['total_stuff']
        ];

        return $this->lendingRepositories->store($payload);
    }
}