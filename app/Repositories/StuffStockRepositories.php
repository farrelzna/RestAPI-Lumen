<?php 

namespace App\Repositories;

use App\Models\StuffStock;

class StuffStockRepositories {
    public function update(array $data)
    {
        // cari data stuff_stock berdasarkan stuff_id di inbound
        $stuffStocks = StuffStock::where("stuff_id", $data["stuff_id"])->first();
        // jika stuff_stock dari stuff terkait udah ada, ambil total_available dan total_defec nya jika tidak 0
        $totalAvailableBefore = $stuffStocks ? $stuffStocks["total_available"] : 0;
        $totalDefecBefore = $stuffStocks ? $stuffStocks["total_defec"] : 0;
        // updateOrCreate biar kalo datanya blm ada, dibuat kalo udah di update
        StuffStock::updateOrCreate([
            "stuff_id" => $data['stuff_id'], // berdasarkan stuff_id karna yang sama dengan inbound bagian ininya
        ], [
            'total_available' => $totalAvailableBefore + $data['total'],
            'total_defec' => $totalDefecBefore,
        ]);

        return StuffStock::where('stuff_id', $data['stuff_id'])->first();
    }
}