<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Repositories\RestorationRepositories;

class RestorationService
{
    private $restorationRepositories;
    public function __construct(RestorationRepositories $restorationRepositories)
    {
        $this->restorationRepositories = $restorationRepositories;
    }

    public function index()
    {
        return $this->restorationRepositories->getAllRestoration();
    }

    public function store(array $data)
    {
        $payload = [
            'user_id' => Auth::user()->id,
            'lending_id' => $data['lending_id'],
            // 'stuff_id' => $data['stuff_id'],
            'date_time' => Carbon::now(),
            'total_good_stuff' => $data['total_good_stuff'],
            'total_defec_stuff' => $data['total_defec_stuff'],
        ];

        return $this->restorationRepositories->store($payload);
    }

    public function payload($data)
    {
        return $this->restorationRepositories->isPayloadValid($data);
    }
}