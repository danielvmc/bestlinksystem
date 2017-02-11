<?php

namespace App\Http\Controllers;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!auth()->attempt(request(['username', 'password']))) {
            return back()->withErrors([
                'message' => 'Bạn đã nhập sai tên đăng nhập hoặc mật khẩu',
            ]);
        }

        flash('Đăng nhập thành công!', 'success');

        return redirect()->home();
    }

    public function destroy()
    {
        auth()->logout();

        return redirect()->home();
    }
}
