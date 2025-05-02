<!-- resources/views/components/toast.blade.php -->
@props([
    'message' => 'Something happened.',
    'level' => 'info',
    'title' => null,
])

<div 
    x-data="{ show: true }" 
    x-show="show"
    x-init="setTimeout(() => show = false, 5000)"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="z-[9999] p-4 bg-white rounded-lg shadow-lg border-l-4 max-w-xs w-full pointer-events-auto"
    :class="{
        'border-green-500 text-green-500': '{{ $level }}' === 'success',
        'border-red-500 text-red-500': '{{ $level }}' === 'error',
        'border-yellow-500 text-yellow-500': '{{ $level }}' === 'warning',
        'border-blue-500 text-blue-500': '{{ $level }}' === 'info',
    }"
>
    <div class="flex items-start">
        <!-- Icon -->
        <div class="mt-1">
            @switch($level)
                @case('success') ✓ @break
                @case('error') ⚠ @break
                @case('warning') ◬ @break
                @default ℹ
            @endswitch
        </div>

        <!-- Message -->
        <div class="ml-3 flex-1">
            <p class="text-sm font-semibold text-gray-900">{{ $title ?? ucfirst($level) }}</p>
            <p class="mt-1 text-sm text-gray-600">{{ $message }}</p>
        </div>

        <!-- Close Button -->
        <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-600">
            &times;
        </button>
    </div>
</div>
