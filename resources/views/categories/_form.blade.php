<div class="form-group mb-3">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control {{ is_invalid($errors, 'name') }}" value="{{ old('name', $category ?? null) }}">
    <x-invalid-feedback name="name" />
</div>
<button class="btn btn-primary" type="submit">{{ isset($category) ? 'Update' : 'Save' }}</button>
