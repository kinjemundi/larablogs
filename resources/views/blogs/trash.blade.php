@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="jumbotron">
        <h1>Trashed Blogs</h1>
    </div>
</div>
<div class="col-md-12">
    @foreach($trashedblog as $blog)
    <h2>
        {{ $blog->title }}
    </h2>
    <p>{{ $blog->body }}</p>


    <form action="{{ route('blogs.restore',$blog->id) }}" method="GET">
        <button type="submit" class="btn btn-success btn-xs pull-left">
            Restore
        </button>
        {{ csrf_field() }}
    </form>
    <form action="{{ route('blogs.permanent-delete',$blog->id) }}" method="POST">
        {{ method_field('delete') }}
        <button type="submit" class="btn btn-danger btn-xs pull-left">
            Permanet Delete
        </button>
        {{ csrf_field() }}
    </form>
    @endforeach
</div>

@endsection