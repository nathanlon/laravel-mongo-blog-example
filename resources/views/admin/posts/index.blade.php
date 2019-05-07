@extends ('layouts.admin.master')

@section ('content')

    <div class="row">
        <div class="col-md-8 blog-main">

            <table class="table">
                <thead>
                    <td>Title</td>
                    <td>Date</td>
                    <td>Actions</td>
                </thead>

                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->getTitle() }}</td>
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

        </div><!-- /.blog-main -->

        @include ('layouts.admin.sidebar')

    </div><!-- /.row -->

@endsection



