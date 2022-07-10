<div class="form-group mb-3">
    <label for="category_id">Category</label>
    <select name="category_id" id="category_id" class="form-select {{ is_invalid($errors, 'category_id') }}">
        <option value=""></option>
        @foreach($categories as $id => $name)
            <option value="{{ $id }}" @selected(old('category_id', $budget ?? null) == $id)>{{ $name }}</option>
        @endforeach
    </select>
    <x-invalid-feedback name="category_id" />
</div>
<div class="form-group mb-3">
    <label for="description">Amount</label>
    <input type="text" name="amount" class="form-control {{ is_invalid($errors, 'amount') }}" value="{{ old('amount', $budget ?? null) }}">
    <x-invalid-feedback name="amount" />
</div>
<div class="form-group mb-3">
    <label for="budget_date">Budget Date</label>
    <select name="budget_date" id="budget_date" class="form-select {{ is_invalid($errors, 'budget_date') }}">
        @php
            $months = [
                'Jan' => 'January',
                'Feb' => 'February',
                'Mar' => 'March',
                'Apr' => 'April',
                'May' => 'May',
                'Jun' => 'June',
                'Jul' => 'July',
                'Aug' => 'August',
                'Sep' => 'September',
                'Oct' => 'October',
                'Nov' => 'November',
                'Dec' => 'December',
            ];
        @endphp
        @foreach($months as $mon => $month)
            <option value="{{ $mon }}" @selected(old('budget_date', $currentMonth) === $mon)>{{ $month }}</option>
        @endforeach
    </select>
    <x-invalid-feedback name="budget_date" />
</div>

<button class="btn btn-primary" type="submit">{{ isset($budget) ? 'Update' : 'Save' }}</button>
