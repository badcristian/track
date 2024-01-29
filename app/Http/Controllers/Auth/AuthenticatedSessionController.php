<?php

namespace App\Http\Controllers\Auth;

use App\Events\LoginAttempt;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $token = $code . 'exp' . now()
                ->addSeconds(config('track.login_code.expires_after'))
                ->timestamp;

        $user->fill(['login_token' => $token])->save();

        event(new LoginAttempt($user, $code));

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
