@props(['name' => 'sparkle', 'class' => 'h-6 w-6'])
@php
    // Satu sumber ikon untuk seluruh situs — garis konsisten (stroke 1.5, 24px grid).
    // Nama komponen: <x-ico> (dinamai "ico" agar tidak bentrok dengan <x-icon> milik blade-icons/Filament).
    $icons = [
        'clock'     => '<circle cx="12" cy="12" r="8.25"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5V12l3 1.75"/>',
        'pin'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21c4-4.5 6-7.9 6-11a6 6 0 10-12 0c0 3.1 2 6.5 6 11z"/><circle cx="12" cy="10" r="2.25"/>',
        'chat'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 1113.6 4.35L19.5 20l-3.75-1.3A7.5 7.5 0 014.5 12z"/><path stroke-linecap="round" d="M9 11h6M9 14h4"/>',
        'utensils'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 3v6a2 2 0 002 2 2 2 0 002-2V3M7 11v10M17 3c-1.6 0-2.8 2-2.8 4.8 0 2.5 1 3.7 2.8 3.9V21"/>',
        'calendar'  => '<rect x="4" y="5" width="16" height="15" rx="2"/><path stroke-linecap="round" d="M4 9.5h16M8.5 3v4M15.5 3v4"/>',
        'users'     => '<circle cx="9.5" cy="8" r="3.2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.5 20v-1a4 4 0 014-4h4a4 4 0 014 4v1M15.5 5.2a3.2 3.2 0 010 5.6M18 15a4 4 0 013 3.87V20"/>',
        'gift'      => '<rect x="4" y="9" width="16" height="11" rx="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 13h16M12 9v11M12 9S10.5 5 8.5 5 6 7.2 8.2 9M12 9s1.5-4 3.5-4 2 2.2-.2 4"/>',
        'snowflake' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3.3 7.5l17.4 9M20.7 7.5l-17.4 9M12 6l-2.2-2M12 6l2.2-2M12 18l-2.2 2M12 18l2.2 2"/>',
        'truck'     => '<rect x="3" y="6.5" width="11" height="9" rx="1"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 9.5h3.5l2.5 2.5v3H14z"/><circle cx="7" cy="17.5" r="1.6"/><circle cx="17" cy="17.5" r="1.6"/>',
        'star'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4l2.3 4.9 5.4.6-4 3.7 1.1 5.3L12 16.9 7.2 18.5l1.1-5.3-4-3.7 5.4-.6z"/>',
        'check'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5l4.5 4.5L19 7"/>',
        'check-circle' => '<circle cx="12" cy="12" r="8.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M8.3 12.4l2.6 2.6 4.8-5.4"/>',
        'sparkle'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3l1.6 4.9 4.9 1.6-4.9 1.6L12 16l-1.6-4.9L5.5 9.5l4.9-1.6z"/>',
        'phone'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 3h3l1.5 5-2 1.5a11 11 0 005 5l1.5-2 5 1.5V21a2 2 0 01-2.2 2A17 17 0 013 5.2 2 2 0 016 3z"/>',
        'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5l8 5.5 8-5.5"/>',
        'instagram' => '<rect x="4" y="4" width="16" height="16" rx="4.5"/><circle cx="12" cy="12" r="3.5"/><circle cx="16.8" cy="7.2" r="1" fill="currentColor" stroke="none"/>',
        'fire'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3s5 3.2 5 8.5a5 5 0 11-9.3-2.6C8.7 10.2 9.6 11 10.6 11 12 11 11 6.5 12 3z"/>',
        'bag'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 8h12l-1 12H7L6 8z"/><path stroke-linecap="round" d="M9 9V7a3 3 0 016 0v2"/>',
        'fish'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.5 12c3-4.2 8-5 12-4 2 .5 4 2 4 4s-2 3.5-4 4c-4 1-9 .2-12-4z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12l2-2M19.5 12l2 2"/><circle cx="8" cy="10.8" r=".7" fill="currentColor" stroke="none"/>',
        'heart'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 20s-7-4.5-7-9.5A3.5 3.5 0 0112 8a3.5 3.5 0 017 2.5C19 15.5 12 20 12 20z"/>',
        'arrow-right' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12h13M12 6l6 6-6 6"/>',
        'sofa'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 11V8a2 2 0 012-2h12a2 2 0 012 2v3M3 12a2 2 0 012 2v3h14v-3a2 2 0 012-2 2 2 0 00-2-2 2 2 0 00-2 2v1H7v-1a2 2 0 00-2-2 2 2 0 00-2 2zM6 20v-1M18 20v-1"/>',
        'route'     => '<circle cx="6" cy="18" r="2"/><circle cx="18" cy="6" r="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 18h6a4 4 0 000-8H9a4 4 0 010-8h5"/>',
    ];
    $path = $icons[$name] ?? $icons['sparkle'];
@endphp
<svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">{!! $path !!}</svg>
