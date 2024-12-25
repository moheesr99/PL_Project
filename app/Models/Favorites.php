<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorites extends Model
{
    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

}
