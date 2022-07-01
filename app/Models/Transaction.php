<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeByCategory($query, Category $category)
    {
        $query->when($category->exists, function ($query) use ($category) {
            $query->where('category_id', $category->id);
        });
    }

    public static function booted()
    {
        self::addGlobalScope('user', function ($query) {
            $query->where('user_id', auth()->id());
        });
    }
}
