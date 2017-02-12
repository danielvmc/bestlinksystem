<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with('links')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        User::create(request(['name', 'username', 'password']));

        return redirect('/admin/users');
    }

    public function destroy(User $user)
    {
        $user->delete();

        flash('Xoá thành công!', 'success');

        return back();
    }
}
