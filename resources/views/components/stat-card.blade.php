@props(['icon', 'label', 'value', 'color' => 'gray'])

@php
    $colorClasses = [
        'gray' => 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300',
        'blue' => 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400',
        'green' => 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400',
        'yellow' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400',
        'purple' => 'bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400',
        'red' => 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400',
    ];
    $colorClass = $colorClasses[$color] ?? $colorClasses['gray'];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 flex items-center gap-6">
    <div class="{{ $colorClass }} rounded-full p-4 text-2xl">
        <i class="fas {{ $icon }}"></i>
    </div>
    <div>
        <p class="text-3xl font-extrabold text-gray-800 dark:text-gray-100">{{ $value }}</p>
        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ $label }}</p>
    </div>
</div>
