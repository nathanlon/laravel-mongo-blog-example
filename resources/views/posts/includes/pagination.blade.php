
<nav class="blog-pagination">
    @if ($nextNumber)
        <a class="btn btn-outline-primary" href="{{ route('post_show_page', ['number' => $nextNumber ]) }}">Older</a>
    @else
        <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Older</a>
    @endif
    @if ($previousNumber)
        <a class="btn btn-outline-primary" href="{{ route('post_show_page', ['number' => $previousNumber ]) }}">Newer</a>
    @else
        <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Newer</a>
    @endif
</nav>
