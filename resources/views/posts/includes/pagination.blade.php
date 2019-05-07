
<nav class="blog-pagination">
    @if ($nextNumber)
        <a class="btn btn-outline-primary" href="{{ route('post_show_page', ['number' => $nextNumber ]) }}">Previous Post</a>
    @else
        <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Previous Post</a>
    @endif
    @if ($previousNumber)
        <a class="btn btn-outline-primary" href="{{ route('post_show_page', ['number' => $previousNumber ]) }}">Next Post</a>
    @else
        <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Next Post</a>
    @endif
</nav>
