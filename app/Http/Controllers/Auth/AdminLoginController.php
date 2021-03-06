<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }
    
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        //validar o formulário
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);
        
        //tentar passar o usuário
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
        {
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->back()->withInput($request->only('email', 'remember'));

        //se está tudo certo, redirecionar o usuário

        //se não, redireciona ele de volta
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('/');
    }
}
