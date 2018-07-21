@extends('layouts.app') 
@section('content');

<div class="container">
    <div class="jumbotron">
        <h1>Manage Users</h1>
    </div>
    <div class="col-md-12">
        <div class="rows">

            {{--
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody> --}} @foreach ($users as $user)
                    <div class="col-md-3">


                        <form action="{{ route('users.update',$user->id) }}" method="post">
                            {{ method_field('patch') }}
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <select name="role_id" class="form-control">
                                    <option selected>{{ $user->role->name }}</option>
                                    <option value="2">Author</option>
                                    <option value="3">Subscriber</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $user->created_at->diffForHumans() }}" disabled>
                            </div>

                            <button class="btn btn-primary btn-sm col-md-3" type="submit">Update</button> {{ csrf_field()
                            }}
                        </form>
                        <form action="{{ route('users.destroy',$user) }}" method="post">
                            {{ method_field('delete') }}
                            <button class="btn btn-danger btn-sm col-md-3" type="submit">Delete</button> {{ csrf_field() }}
                        </form>
                    </div>
                    @endforeach {{-- </tbody>
            </table> --}}

        </div>
    </div>

</div>
@endsection