<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Notifications\VerifyUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return inertia('Auth/Login', [
            'status' => session('status')
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|string|email|max:255']);

        $user = User::where(['email' => $request->input('email')])->first();

        if (!$user) {
            return redirect()->route('register', [
                'email' => $request->input('email'),
                'number' => $request->input('number')
            ]);
        }

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice', ['email' => $user->getEmailForVerification()]);
        }

        $code = rand(1111, 9999);

        $user->fill([
            'login_token' => $code . 'exp' . now()->addHour()->timestamp
        ])->save();

        $user->notify(new VerifyUser($code));

        return redirect()
            ->route('verify.user', ['email' => $request->input('email')])
            ->with(['status' => 'Code was sent to your email']);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
