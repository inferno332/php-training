@props(['role'])

@php
$classes = match ($role) {
    'admin' => 'bg-red-100 text-red-800',
    'manager' => 'bg-blue-100 text-blue-800',
    'user' => 'bg-gray-100 text-gray-800',
    default => 'bg-gray-100 text-gray-800'
};
@endphp

<span {{ $attributes->merge(['class' => 'px-2 py-1 text-xs font-medium rounded-full ' . $classes]) }}>
    {{ ucfirst($role) }}
</span>
