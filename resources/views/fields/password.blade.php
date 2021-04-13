<div class="mb-3">
    <label class="form-label">{{ $name }}</label>
    <input type="password" class="form-control" value="{{ old($full_name) ?? $value ?? '' }}" name="{{ $full_name }}">
</div>
