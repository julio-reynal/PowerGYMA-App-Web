@props(['icon', 'label', 'value', 'type' => null])

<div class="flex items-start gap-4">
    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg text-gray-500 dark:text-gray-400">
        <i class="fas {{ $icon }}"></i>
    </div>
    <div>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</p>
        @if($value)
            @if($type === 'email')
                <a href="mailto:{{ $value }}" class="text-base font-semibold text-blue-600 hover:underline dark:text-blue-400">{{ $value }}</a>
            @elseif($type === 'tel')
                <a href="tel:{{ $value }}" class="text-base font-semibold text-blue-600 hover:underline dark:text-blue-400">{{ $value }}</a>
            @else
                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">{{ $value }}</p>
            @endif
        @else
            <p class="text-base text-gray-400 dark:text-gray-500 italic">No especificado</p>
        @endif
    </div>
</div>
