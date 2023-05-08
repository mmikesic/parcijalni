@extends('layouts.app')

@section('title', 'Users')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Users</h1>
            @auth
                @can('create', App\Models\User::class)
                    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add User</a>
                @endcan
            @endauth
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->type }}</td>
                            <td>
                                <div class="btn-group">
                                    @can('update', $user)
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit</a>
                                    @endcan
                                    @can('delete', $user)
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        <tr class="spacer"></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection