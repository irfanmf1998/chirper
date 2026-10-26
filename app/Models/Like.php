<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    public function chirp(): BelongsTo
    {
        return $this->belongsTo(Chirp::class);
    }
}
