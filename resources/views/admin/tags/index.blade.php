@extends ('layouts.admin.master')

@section ('content')

    <div class="row">
        <div class="col-md-8 blog-main">

            <h3>Edit Tags</h3>

            <table class="table">
                <thead>
                    <td>Name</td>
                    <td>Actions</td>
                </thead>

                @foreach($tags as $tag)
                    <tr>
                        <td><a href="#">{{ $tag->getName() }}</a></td>
                        <td>
                            {{--<a class="btn btn-primary" href="{{ route('admin_tag_edit', ['id' => $tag->getId()]) }}">Edit</a>--}}
                            <form action="{{ route('admin_tag_delete', ['id' => $tag->getId()]) }}" method="post">
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



