@extends('layouts.app')
@include('partials.meta_dynamic') 
@section('content');
 {{-- 
@section('meta_title') {{ $blog->meta_title
}}
@endsection
 
@section('meta_description') {{ $blog->meta_description }}
@endsection
 --}}

<div class="container">
    <article>
        <div class="jumbotron">

            <div class="col-md-12">
                @if($blog->featured_image)
                <img class="img-responsive featured_image" src="/images/featured_image/{{ $blog->featured_image ? $blog->featured_image : '' }}"
                    alt="{{ str_limit($blog->title,50) }}"> @endif
            </div>
            {{--
            <div class="col-md-12"> --}}
                <h1>{{ $blog->title }}</h1>
                {{-- </div> --}} 
            @if (Auth::user())
                @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2 && Auth::user()->id === $blog->user_id)
                    <div class="col-md-12">
                        <div class="input-group">
                            <a href="{{ route('blogs.edit',$blog->id) }}" class="btn btn-primary btn-sm pull-left btn-margin-right">Edit </a>
                            <form action="{{ route('blogs.delete',$blog->id) }}" method="POST">
                                {{ method_field('delete') }}
                                <button class="btn btn-danger btn-sm pull-left" type="submit">delete</button> {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                @endif
            @endif
            


        </div>
        <div class="col-md-12">
            {!! $blog->body !!}
            <br/>
             @if ($blog->user) 
                Author : <a href="{{ route('users.show',$blog->user->slug) }}">{{ $blog->user->name }}</a> | Posted : {{ $blog->created_at->diffForHumans() }}
             @endif

            <hr>
            <strong>Categories : </strong> @foreach ($blog->category as $category)
            <span> <a href="{{ route('categories.show',$category->slug) }}">{{ $category->name }}</a></span> @endforeach

        </div>
    </article>
    <hr>
    <aside>
    <div id="disqus_thread"></div>
    <script>
    (function() { // DON'T EDIT BELOW THIS LINE
    var d = document, s = d.createElement('script');
    s.src = 'https://kinje.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
    })();
    
    </script>
    
    </aside>
</div>
@endsection