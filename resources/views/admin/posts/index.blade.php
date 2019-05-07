@extends ('layouts.admin.master')

@section ('content')

    <div class="row">
        <div class="col-md-8 blog-main">

            <h3>All Posts</h3>
            @if (count($posts) > 0)
                <table class="table">
                    <thead>
                        <td>Title</td>
                        <td>Date</td>
                        <td>Actions</td>
                    </thead>

                    @foreach($posts as $post)
                        <tr>
                            <td><a href="{{ route('post_show', ['id' => $post->getId()]) }}">{{ $post->getTitle() }}</a></td>
                            <td>{{ $post->getDateString() }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('admin_post_edit', ['id' => $post->getId()]) }}">Edit</a>
                                <form action="{{ route('admin_post_delete', ['id' => $post->getId()]) }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="submit" class="btn btn-danger" value="Delete"/>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div>There are no posts yet. You can create a post <a href="{{ route('admin_post_create') }}">here</a>.</div>
            @endif

        </div><!-- /.blog-main -->

        @include ('layouts.admin.sidebar')

    </div><!-- /.row -->

@endsection



