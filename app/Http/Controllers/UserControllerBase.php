<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
{
    $users = User::where('id', '!=', auth()->user()->id)->get();

    return view('users.index', compact('users'));
}

public function create()
{
    return view('users.create');
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required',
    ]);

    User::create($validatedData);

    return redirect()->route('users.index');
}

}
