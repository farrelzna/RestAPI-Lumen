<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InboundStuff extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['stuff_id', 'total', 'date', 'proof_file'];

    public function stuff()
    {
        return $this->belongsTo(Stuff::class);
    }
}
