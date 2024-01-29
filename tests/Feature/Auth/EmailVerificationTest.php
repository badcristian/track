<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Inertia\Testing\AssertableInertia as Assert;

test('email verification screen can be rendered', function () {

    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $response = $this->get(route('verification.notice', ['email' => $user->email]));

    $response->assertInertia(fn(Assert $page) => $page
        ->component('Auth/VerifyEmail'));
});

test('redirect to home if email already verified', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->get('/verify-email', ['email' => $user->email]);

    $response->assertRedirect();
});

test('email can be verified', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(RouteServiceProvider::HOME . '?verified=1');
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});
