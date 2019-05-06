@extends ('layouts.admin.master')

@section ('content')

    <h1>Login</h1>

    <form method="post" action="/admin/login">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    @include('layouts.errors')

@endsection
