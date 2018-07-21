@extends('layouts.app')
    @include('partials.meta_static') 
@section('content');

<div class="container">

    @if (Session::has('blog_created_message'))
    <div class="alert alert-success">
        {{ Session::get('blog_created_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
    @endif 
    @foreach($blogs as $blog)
        <div class="col-md-8 offset-md-2">

            <h2><a href="{{ route('blogs.show',[$blog->slug]) }}">{{ $blog->title }}</a></h2>
            <div class="col-md-12">
                @if($blog->featured_image)
                <img class="img-responsive featured_image" style="width:300px;height:auto" src="/images/featured_image/{{ $blog->featured_image ? $blog->featured_image : '' }}"
                    alt="{{ str_limit($blog->title,50) }}"/>
                 @endif
            </div>
            <div class="lead">{!! str_limit($blog->body,200) !!}</div>
            <br/> 
            @if ($blog->user) 
                Author : <a href="{{ route('users.show',$blog->user->slug) }}">{{ $blog->user->name }}</a>        | Posted : {{ $blog->created_at->diffForHumans() }} 
            @endif
        </div>
        
    @endforeach
</div>
@endsection