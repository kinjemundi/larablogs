@extends('layouts.app')
@section('content');
@include('partials.tinymce');    
    <div class="container-fluid">
        <div class="jumbotron">
            <h1>Edit Blog</h1>
        </div>
        <div class="col-md-12">
            <form action="{{ route('blogs.update',$blog->id) }}" method="post" enctype="multipart/form-data">
                {{ method_field('patch') }}
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $blog->title }}">
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea name="body" class="form-control my-editor">{{ $blog->body }}</textarea>
                    {{-- <textarea name="body" class="form-control">{{ $blog->body }}</textarea> --}}
                </div>
                <div class="form-group">
                    <label for="featured_image">Featured Image</label>
                    <input type="file" name="featured_image" class="form-control">
                </div>
                <div class="form-group form-check form-check-inline">
                    {{ $blog->category->count()?'Current Categories  ':'' }}
                    @foreach ($blog->category as $category)
                        <input type="checkbox" name="category_id[]" value="{{ $category->id }}" class="form-check-input" checked>
                        <label class="form-check-label">{{ $category->name }}</label>
                    @endforeach
                </div>
                <div class="form-group form-check form-check-inline">
                    {{ $filtered->count()?'Unused Categories  ':'' }}
                    @foreach ($filtered as $cat)
                        <input type="checkbox" name="category_id[]" value="{{ $cat->id }}" class="form-check-input">
                        <label class="form-check-label">{{ $cat->name }}</label>
                    @endforeach
                </div>
                <button class="btn btn-primary" type="submit">Update Blog</button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>

@endsection