@extends('layouts.app')
@section('content');
<div class="container-fluid">
    <div class="jumbotron">
        <h2>
            {{ $category->name }}
        </h2>
        <a href="{{ route('categories.edit',$category->id) }}" class="btn btn-warning btn-sm pull-left">Edit</a>
        <form action="{{ route('categories.destroy',$category->id) }}" method="POST">
            {{ method_field('delete') }}
            <button class="btn btn-danger btn-sm pull-left" type="submit">
                Delete
            </button>
            {{ csrf_field() }}
        </form>
    </div>
</div>
<div class="col-md-12">
    @foreach ($category->blog as $blog)
        <h3><a href="{{ route('blogs.show',[$blog->slug]) }}">{{ $blog->title }}</a></h3>
    @endforeach
</div>


@endsection