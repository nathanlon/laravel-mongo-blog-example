
<div class="blog-post">
    <h2 class="blog-post-title">{{ $post->getTitle() }}</h2>

    <p class="blog-post-meta">{{ $post->getDateString() }} by <a href="#">Nathan</a></p>

    {!! $post->getBody() !!}

</div><!-- /.blog-post -->
