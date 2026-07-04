@props(['name' => 'sparkle', 'size' => 'md', 'tone' => 'maroon'])
@php
    $box = match ($size) { 'lg' => 'h-16 w-16', 'sm' => 'h-10 w-10', default => 'h-12 w-12' };
    $ic  = match ($size) { 'lg' => 'h-7 w-7', 'sm' => 'h-[18px] w-[18px]', default => 'h-[22px] w-[22px]' };
    $skin = $tone === 'light'
        ? 'bg-cream-50 text-maroon-700 ring-1 ring-inset ring-maroon-700/10'
        : 'bg-gradient-to-br from-maroon-700 to-maroon-900 text-gold-300 ring-1 ring-inset ring-gold-400/25';
@endphp
<span {{ $attributes->merge(['class' => "flex $box flex-none items-center justify-center rounded-full $skin shadow-[0_6px_16px_-8px_rgba(74,22,21,0.55)]"]) }}>
    <x-ico :name="$name" :class="$ic" />
</span>
