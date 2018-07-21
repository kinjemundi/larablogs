@extends('layouts.app')
@section('content');
    
    <div class="container-fluid">
        <div class="jumbotron">
            <h1>Create Category</h1>
        </div>
        <div class="col-md-12">
            <form action="{{ route('categories.store') }}" method="post">
                <div class="form-group">
                    <label for="name">name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                
                <button class="btn btn-primary" type="submit">New Category</button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>

@endsection