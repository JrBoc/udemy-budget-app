<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    use HasUser;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'category_id', 'category_id');
    }

    public function scopeByMonth($query, string $month = 'this month')
    {
        $query
            ->where('budget_date', '>=', Carbon::parse('first day of ' . $month))
            ->where('budget_date', '<=', Carbon::parse('last day of ' . $month));
    }

    public function balance()
    {
        return $this->amount - $this->transactions()->sum('amount');
    }

    public static function booted()
    {
        self::addGlobalScope('user', function ($query) {
            $query->where('user_id', auth()->id());
        });

        static::saving(function (Budget $budget) {
            $budget->user_id = $budget->user_id ? : auth()->id();
        });
    }
}
