@extends ('layouts.master')

@section ('content')

    <div class="row">
        <div class="col-md-8 blog-main">

            @include ('posts.includes.post')

            @include ('posts.includes.pagination')

        </div><!-- /.blog-main -->

        @include ('layouts.sidebar')

    </div><!-- /.row -->

@endsection
