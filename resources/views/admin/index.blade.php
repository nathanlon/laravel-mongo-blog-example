@extends ('layouts.admin.master')

@section ('jumbotron')

    <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
        <div class="col-md-6 px-0">
            <h1 class="display-4 font-italic">Creating a blog</h1>
            <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently about what’s most interesting in this post’s contents.</p>
            <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Continue reading...</a></p>
        </div>
    </div>

@endsection

@section ('content')

    <div class="row">
        <div class="col-md-8 blog-main">
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                <a href="/admin/posts/create">Create a Post</a>
            </h3>
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                <a href="#">Edit a Post</a>
            </h3>
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                <a href="#">Edit About</a>
            </h3>
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                <a href="#">Edit Tags</a>
            </h3>
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                <a href="#">Edit Categories</a>
            </h3>

        </div><!-- /.blog-main -->

        @include ('layouts.admin.sidebar')

    </div><!-- /.row -->

@endsection



