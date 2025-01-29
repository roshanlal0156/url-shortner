<div id="header">
    <div id="header-left">
        <a href="{{ route('home') }}">
        <div id="header-logo">
            <span>&gt;</span> URL <span>&lt;</span>
        </div>
        </a>
        <div id="header-title">{{ $pageTitle }}</div>
    </div>
    @if (auth()->check())
    <a href="{{ route('logout') }}" ><div id="header-logout-btn">Logout</div></a>
    @endif
</div>
