@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $user->name }}</h1>
            <p>Email: {{ $user->email }}</p>
            <p>Role: {{ $user->role }}</p>
            <p>Created at: {{ $user->created_at }}</p>
            <p>Updated at: {{ $user->updated_at }}</p>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
