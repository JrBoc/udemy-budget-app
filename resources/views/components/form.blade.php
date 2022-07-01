@props([
    'action' => '#',
    'method' => 'get',
])

<form action="{{ $action }}" method="{{ strtolower($method) !== 'get' ? 'post': 'get' }}" {{ $attributes }}>
    @csrf
    @if(! in_array(strtolower($method), ['get', 'post']))
        @method($method)
    @endif
    {{ $slot }}
</form>
