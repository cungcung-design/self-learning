<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('index', compact('users'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:1'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : null,
        ]);

        return redirect('/users');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['nullable', 'string', 'min:1'],
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect('/users');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/users');
    }
}
