@extends('layouts.app')
 @section('content');
<div class="container-fluid">
    <div class="jumbotron">
        @if (Auth::user() && Auth::user()->role_id === 1)
            <h1>Admin Dashbord</h1>
        @elseif(Auth::user() && Auth::user()->role_id === 2)
            <h1>Author Dashbord</h1>
        @elseif(Auth::user() && Auth::user()->role_id === 3)
            <h1>User Dashbord</h1>
        @endif
        
    </div>
    @if (Auth::user() && Auth::user()->role_id === 1)
        <div class="col-md-12">
                <a href="{{ route('blogs.new') }}" class="btn btn-primary">Create Blog</a>
                <a href="{{ route('blogs.trash') }}" class="btn btn-danger">Trashed Blog</a>
                <a href="{{ route('admin.blogs') }}" class="btn btn-warning">Publish Blog</a>
                <a href="{{ route('categories.create') }}" class="btn btn-success">Create Category</a>
                <a href="{{ route('users.index') }}" class="btn btn-info">User Manager</a>
        </div>
    @endif
    @if (Auth::user() && Auth::user()->role_id === 2)
        <div class="col-md-12">
                <a href="{{ route('blogs.new') }}" class="btn btn-primary">Create Blog</a>
                <a href="{{ route('admin.blogs') }}" class="btn btn-warning">Publish Blog</a>
                <a href="{{ route('categories.create') }}" class="btn btn-success">Create Category</a>
        </div>
    @endif
    @if (Auth::user() && Auth::user()->role_id === 3)
        <div class="col-md-12">
                <a href="#" class="btn btn-primary">What can I do</a>
                
        </div>
    @endif
</div>
 @endsection