<?php

namespace App\Models;

trait HasUser
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
