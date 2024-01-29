<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = User::find($request->route('id'));

        if (!$user) {
            return redirect(route('login'))->with(['status', 'Something went wrong, try again']);
        }

        if (!hash_equals(sha1($user->getEmailForVerification()), (string)$request->route('hash'))) {
            return redirect(route('login'))->with(['status', 'Something went wrong, try again']);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
    }
}
