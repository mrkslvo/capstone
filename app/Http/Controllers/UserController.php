<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        // Use consistent roles
        $users = User::whereIn('role', ['admin', 'bns', 'bhw', 'rhu'])->get();

        return Inertia::render('Admin/User', [
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        sleep(1);

        $fields = $request->validate([
            'firstname'       => 'required|string',
            'lastname'        => 'required|string',
            'purok'           => 'required|integer|min:1',
            'role'            => 'required|in:admin,bns,bhw,rhu,parent', // fixed
            'contact_number'  => 'required|digits:10',
            'username'        => 'required|string|unique:users,username',
            'password'        => 'required|confirmed|min:5|max:16',
        ]);

        // Hash password
        $fields['password'] = bcrypt($fields['password']);

        $user = User::create($fields);


        return back()->with('success', 'User created successfully.');
    }

    public function update(Request $request, User $user)
    {
        sleep(1);

        $fields = $request->validate([
            'firstname'       => 'required|string',
            'lastname'        => 'required|string',
            'purok'           => 'required|integer|min:1',
            'role'            => 'required|in:admin,bns,bhw,rhu,parent', // fixed
            'contact_number'  => 'required|digits:10',
            'username'        => 'required|string|unique:users,username,' . $user->id,
            'password'        => 'nullable|confirmed|min:5|max:16',
        ]);

        // Handle password hashing only if updated
        if (!empty($fields['password'])) {
            $fields['password'] = bcrypt($fields['password']);
        } else {
            unset($fields['password']);
        }

        $user->update($fields);

        return back()->with('success', 'User updated successfully.');
    }
}
