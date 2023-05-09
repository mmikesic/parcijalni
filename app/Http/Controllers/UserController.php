<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $types = ['Administrator', 'Team Leader', 'User'];

        return view('users.index', compact('users', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = ['Administrator', 'Team Leader', 'User'];

        return view('users.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'type' => 'required|in:Administrator,Team Leader,User',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters.',
            'type.required' => 'The type field is required.',
            'type.in' => 'Please select a valid user type.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be of type jpeg, png, jpg, gif, or svg.',
            'image.max' => 'The image may not be greater than 2 megabytes.'
        ]);

        $user = new User;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->type = $validatedData['type'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/images/' . $filename);
            $image->move(public_path('uploads/images'), $filename);
            $user->image = $filename;
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
{
    $types = ['Administrator', 'Team Leader', 'User'];
    return view('users.edit', compact('user', 'types'));
}


/**
 * Update the specified resource in storage.
 */
public function update(Request $request, User $user)
{
    $validatedData = $request->validate([
        'name' => 'required',
        'email' => "required|email|unique:users,email,{$user->id}",
        'password' => 'nullable|min:8',
        'type' => 'required|in:Administrator,Team Leader,User',
    ], [
        'name.required' => 'The name field is required.',
        'email.required' => 'The email field is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email address is already taken.',
        'password.min' => 'The password must be at least 8 characters.',
        'type.required' => 'The type field is required.',
        'type.in' => 'Please select a valid user type.',
    ]);

    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    
    if ($validatedData['password']) {
        $user->password = Hash::make($validatedData['password']);
    }
    
    $user->type = $validatedData['type'];
    $user->save();

    return redirect()->route('users.show', $user)
        ->with('success', 'User updated successfully.');
} 

/**
 * Remove the specified resource from storage.
 */
public function destroy(User $user)
{
    $user->delete();

    return redirect()->route('users.index')
        ->with('success', 'User deleted successfully.');
}

public function updateProfilePicture(Request $request)
{
    $validatedData = $request->validate([
        'profile_picture' => 'required|image|max:2048'
    ], [
        'profile_picture.required' => 'The profile picture field is required.',
        'profile_picture.image' => 'The uploaded file must be an image.',
        'profile_picture.max' => 'The image may not be greater than 2 megabytes.'
    ]);

    $user = auth()->user();
    if ($request->hasFile('profile_picture')) {
        $image = $request->file('profile_picture');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('uploads/images/' . $filename);
        $image->move(public_path('uploads/images'), $filename);
        $user->profile_picture = $filename;
        $user->save;
    }

    return redirect()->back()
        ->with('success', 'Profile picture updated successfully.');
}
}
