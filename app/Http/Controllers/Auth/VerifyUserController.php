<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class VerifyUserController extends Controller
{
    public function create(Request $request): Response
    {
        return inertia('Auth/VerifyUser', [
            'email' => $request->input('email'),
            'status' => session('status')
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
            'code' => ['required', 'digits:4']
        ]);

        $user = User::where(['email' => $request->input('email')])->first();

        [$code, $expires] = explode('exp', $user->login_token);

        if (!hash_equals((string)$code, (string)$request->input('code'))) {
            return back()->withErrors(['code' => 'Code is not valid']);
        }

        if ((int)now()->timestamp > (int)$expires) {
            return back()->withErrors(['code' => 'Code expired. Please retry']);
        }

        Auth::login($user, boolval($request->input('remember')));

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
