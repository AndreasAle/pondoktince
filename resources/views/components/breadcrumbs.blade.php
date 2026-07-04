@php $items = seo()->breadcrumbs; @endphp
@if(count($items) > 1)
<nav aria-label="Breadcrumb" class="container-x pt-6">
    <ol class="flex flex-wrap items-center gap-1 text-sm text-charcoal/60">
        @foreach($items as $i => $item)
            <li class="flex items-center gap-1">
                @if(!$loop->last)
                    <a href="{{ $item['url'] }}" class="hover:text-maroon-700">{{ $item['name'] }}</a>
                    <span class="text-charcoal/30">/</span>
                @else
                    <span class="font-medium text-charcoal/80" aria-current="page">{{ $item['name'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif
