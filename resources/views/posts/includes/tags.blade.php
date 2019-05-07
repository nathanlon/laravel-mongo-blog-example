
<div class="p-4">
    <h4 class="font-italic">Tags</h4>
    <ol class="list-unstyled">
        @foreach ($tags as $tag)
            <li><a href="{{ route('posts_index_tag', ['id' => $tag->getId()]) }}">{{ $tag->getName() }}</a></li>
        @endforeach
    </ol>
</div>
