<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BudgetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'min:0', 'numeric'],
            'category_id' => ['required', 'integer', Rule::exists(Category::class, 'id')],
            'budget_date' => ['required', 'date_format:M'],
        ];
    }
}
