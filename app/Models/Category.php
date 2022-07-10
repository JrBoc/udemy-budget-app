<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use HasUser;

    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'category_id', 'id');
    }

    public static function booted()
    {
        self::addGlobalScope('user', function ($query) {
            $query->where('user_id', auth()->id());
        });

        static::saving(function (Category $category) {
            $category->user_id = $category->user_id ? : auth()->id();
            $category->slug = str($category->name)->slug();
        });
    }
}
