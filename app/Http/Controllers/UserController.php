<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        if ($request->wantsJson()) {
            return response()->json($users);
        }

        // ✅ arahkan ke folder user
        return view('user.index', compact('users'));
    }

    public function create()
    {
        // ✅ arahkan ke folder user
        return view('user.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'User created', 'user' => $user], 201);
        }

        return redirect()->route('user.index')->with('success', 'User successfully created');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        // ✅ arahkan ke folder user
        return view('user.edit', compact('user'));
    }

    public function show(User $user)
    {
        if (request()->wantsJson()) {
            return response()->json($user);
        }

        return abort(404); // atau redirect sesuai kebutuhan web
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'User updated', 'user' => $user]);
        }

        return redirect()->route('user.index')->with('success', 'User successfully updated');
    }

    public function destroy(User $user)
    {
        $user->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'User deleted']);
        }

        return redirect()->route('user.index')->with('success', 'User successfully deleted');
    }
}
