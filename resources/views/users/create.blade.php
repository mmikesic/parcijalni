@extends('layouts.app')

@section('title', 'Moja stranica')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Add User</h1>
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                      <label for="password_confirmation">Confirm Password</label>
                       <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                     @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control">
                        <option value="User" {{ old('type') == 'User' ? 'selected' : '' }}>User</option>
                         <option value="Team Leader" {{ old('type') == 'Team Leader' ? 'selected' : '' }}>Team Leader</option>
                        <option value="Administrator" {{ old('type') == 'Administrator' ? 'selected' : '' }}>Administrator</option>

                        </select>
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control-file">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>
    </div>
@endsection
