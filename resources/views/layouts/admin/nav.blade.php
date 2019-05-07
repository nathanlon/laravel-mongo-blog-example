
<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <a class="text-muted" href="/">View Blog</a>
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="/admin">Blog Admin</a>
            </div>

            <div class="col-4 d-flex justify-content-end align-items-center">
                @guest
                    {{--<li class="nav-item">--}}
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('register') }}">{{ __('Register') }}</a>
                    {{--</li>--}}
                    {{--@if (Route::has('register'))--}}
                        {{--<li class="nav-item">--}}
                            {{--<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
                        {{--</li>--}}
                    {{--@endif--}}
                @else
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                       {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
    </header>

    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            <a class="p-2 text-muted" href="{{ route('admin_posts_index') }}">Posts</a>
            <a class="p-2 text-muted" href="{{ route('admin_home') }}">Admin Home</a>
            <a class="p-2 text-muted" href="#">Tags</a>
        </nav>
    </div>

    @yield ('jumbotron')

</div>
