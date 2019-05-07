@extends ('layouts.admin.master')

@section ('content')

    <h1>Edit Post</h1>

    <form method="post" action="/admin/posts/{{ $post->getId() }}/edit">
        {{ csrf_field() }}

        <div class="form-group">
            <label>Created: {{ $post->getDateString() }}</label>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Enter a title" name="title" value="{{ $post->getTitle() }}">
        </div>
        <div class="form-group">
            <label for="body">Body (any HTML for now)</label>
            <textarea class="form-control" id="body" name="body">{{ $post->getBody() }}</textarea>
        </div>
        {{--<div class="form-group">--}}
            {{--<label for="tags">Tags</label>--}}
            {{--<input type="text" class="form-control" id="tags" placeholder="Tags may have multiple words - separate with a comma" name="tags">--}}
            {{--<small id="emailHelp" class="form-text text-muted">Enter tags separated by a comma</small>--}}
        {{--</div>--}}

        <div class="form-group">
            <div>Existing Tags</div>
            @foreach ($tags as $tag)
                <label for="tag_{{ $tag->getId() }}" style="margin-right: 10px;">
                    <input type="checkbox" name="tag_{{ $tag->getId() }}" {{ isset($checkedTags[$tag->getId()]) ? 'checked' : '' }}>
                    {{ $tag->getName() }}
                </label>
            @endforeach
        </div>

        <div class="form-group">
            <label for="newTag">New Tags</label>
            <input type="text" class="form-control" id="newTag" placeholder="Optional new tags (comma separated)" name="new_tags">
        </div>

        <button type="submit" class="btn btn-primary">Publish</button>
    </form>

    @include('layouts.errors')

@endsection
