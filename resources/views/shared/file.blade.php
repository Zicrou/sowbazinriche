@php
    $type ??= 'text';
    $class ??= null;
    $name ??= '';
    $value ??= '';
    $label ??= ucfirst($name);
@endphp

<div @class(["form-group", $class])>
    <label for="{{ $name }}">{{ $label }}</label>
        <input class="form-control @error($name) is-invalid @enderror" type="file" id="{{ $name }}" name="{{ $name }}[]" value="{{ old($name, $value) }}">
    
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>