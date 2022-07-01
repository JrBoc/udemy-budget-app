<div class="form-group mb-3">
    <label for="description">Description</label>
    <input type="text" name="description" class="form-control {{ is_invalid($errors, 'description') }}" value="{{ old('description', $transaction ?? null) }}">
    <x-invalid-feedback name="description" />
</div>
<div class="form-group mb-3">
    <label for="amount">Amount</label>
    <input type="number" name="amount" class="form-control {{ is_invalid($errors, 'amount') }}" value="{{ old('amount', $transaction ?? null) }}">
    <x-invalid-feedback name="amount" />
</div>
<div class="form-group mb-3">
    <label for="category_id">Category</label>
    <select name="category_id" id="category_id" class="form-select {{ is_invalid($errors, 'category_id') }}">
        <option value=""></option>
        @foreach($categories as $id => $name)
            <option value="{{ $id }}" @selected(old('category_id', $transaction ?? null) == $id)>{{ $name }}</option>
        @endforeach
    </select>
    <x-invalid-feedback name="category_id" />
</div>
<button class="btn btn-primary" type="submit">{{ isset($transaction) ? 'Update' : 'Save' }}</button>
