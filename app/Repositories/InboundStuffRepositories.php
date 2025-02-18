<?php

namespace App\Repositories;

use App\Models\StuffStock;
use Illuminate\Support\Str;
use App\Models\InboundStuff;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InboundStuffRepositories
{
    public function getAllInboundStuff()
    {
        return InboundStuff::paginate(10);
    }
    public function uploadImage($file)
    {
        $imageName = Str::random(5) . "." . $file->getClientOriginalExtension();

        $storageDirectory = storage_path("app/public/images");

        if (!File::exists($storageDirectory)) {
            File::makeDirectory($storageDirectory, 0755, true);
        }

        $file->move($storageDirectory, $imageName);

        $publicDirectory = base_path("public/storage");
        if (!File::exists($publicDirectory)) {
            File::link(storage_path(
                "app/public"
            ), $publicDirectory);
        }

        $imageLink = env('APP_URL') . 'storage/images/' . $imageName;
        return $imageLink;
    }
    public function storeInbound(array $data)
    {
        return InboundStuff::create($data);
    }
    public function deleteInboundStuff($id)
    {
        $inboundStuff = InboundStuff::find($id);
        $stuffStock = StuffStock::where('stuff_id', $inboundStuff->stuff_id)->first();

        if ($inboundStuff->total > $stuffStock->total_available) {
            response()->json([
                'success' => false,
                'message' => 'Stock not enough'
            ], 400)->send();
            exit();
        }

        $stuffStock->total_available = $stuffStock->total_available - $inboundStuff->total;
        $stuffStock->save();

        $imagePath = storage_path("app/public/images/" . basename($inboundStuff->proof_file));
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $inboundStuff->delete();

        return $inboundStuff;
    }
}