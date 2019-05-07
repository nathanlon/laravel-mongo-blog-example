
<div class="blog-post">
    <h2 class="blog-post-title">{{ $post->getTitle() }}</h2>

    <p class="blog-post-meta">{{ $post->getDateString() }} by <a href="#">Nathan</a></p>

    {!! $post->getBody() !!}

    <hr>
    <h4>Tagged with:</h4>

    |
    @foreach ($post->tags()->get() as $tag)
        <a href="{{ route('posts_index_tag', ['id' => $tag->getId()]) }}">{{ $tag->getName() }}</a> |
    @endforeach
</div><!-- /.blog-post -->
