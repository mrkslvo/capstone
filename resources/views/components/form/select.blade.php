@props([
    'name',
    'model' => null,
    'class' => '',
])

   <select
    name="{{ $name }}"
    @if ($model) x-model="{{ $model }}" @endif
    {{ $attributes->merge(['class' => 'w-full px-4 py-2 border rounded-md ' . $class]) }}>
    {{ $slot }}
</select>
