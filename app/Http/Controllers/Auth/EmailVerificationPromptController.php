<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|Response
    {
        $request->validate(['email' => 'required|string|email|max:255|exists:users,email']);

        $user = User::where(['email' => $request->input('email')])->first();

        return $user->hasVerifiedEmail()
            ? redirect()->intended(RouteServiceProvider::HOME)
            : inertia('Auth/VerifyEmail', [
                'email' => $request->input('email'),
                'status' => session('status')
            ]);
    }
}
