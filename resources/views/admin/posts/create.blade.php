@extends ('layouts.admin.master')

@section ('content')

    <h1>Create a post</h1>

    <form method="post" action="/admin/posts">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Enter a title" name="title">
        </div>
        <div class="form-group">
            <label for="body">Body (any HTML for now)</label>
            <textarea class="form-control" id="body" name="body"></textarea>
        </div>

        <div class="form-group">
            <div>Existing Tags</div>
            @foreach ($tags as $tag)
                <label for="tag_{{ $tag->getId() }}" style="margin-right: 10px;">
                    <input type="checkbox" name="tag_{{ $tag->getId() }}">
                    {{ $tag->getName() }}
                </label>
            @endforeach
        </div>

        <div class="form-group">
            <label for="newTag">New Tag</label>
            <input type="text" class="form-control" id="newTag" placeholder="Optional new tags (comma separated)" name="new_tags">
        </div>

        <button type="submit" class="btn btn-primary">Publish</button>
    </form>

    @include('layouts.errors')

@endsection
