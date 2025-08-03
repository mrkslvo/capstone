@props([
    'type' => 'text',
    'name',
    'model' => null,
    'value' => null,
    'id' => null,
    'placeholder' => null,
    'class' => '', // extra classes
    'hidden' => false,
])

   
<input
    type="{{ $type }}"
    name="{{ $name }}"
    @if ($model) x-model="{{ $model }}" @endif
    @if ($value) value="{{ $value }}" @endif
    @if ($id) id="{{ $id }}" @endif
    @if ($placeholder) placeholder="{{ $placeholder }}" @endif
   {{ $attributes->merge(['class' => 'w-full px-4 py-2 border rounded-md ' . ($hidden ? 'hidden ' : '') . $class]) }}>
