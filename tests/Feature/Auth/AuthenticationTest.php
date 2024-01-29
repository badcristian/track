<?php

use App\Models\User;
use App\Notifications\VerifyUser;
use App\Providers\RouteServiceProvider;

test('login screen can be rendered', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
});

test('unregistered user will be redirected', function () {
    $email = fake()->email();
    $response = $this->post(route('login'), [
        'email' => $email
    ]);

    $response->assertRedirect(route('register', ['email' => $email]));
});

test('user with unverified email will be redirected', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->post(route('login'), [
        'email' => $user->email
    ]);

    $response->assertRedirect(route('verification.notice', ['email' => $user->email]));
});

test('can login using the provided code', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = $this->post(route('login'), [
        'email' => $user->email,
    ]);

    $response->assertRedirect(route('verify.user', ['email' => $user->email]));

    Notification::assertSentTo($user, VerifyUser::class, function ($notification) use ($user) {

        $response = $this->post(route('verify.user', [
            'email' => $user->email,
            'code' => $notification->code
        ]));

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);

        return true;
    });
});

test('can not login using expired code', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = $this->post(route('login'), [
        'email' => $user->email,
    ]);

    $response->assertRedirect(route('verify.user', ['email' => $user->email]));

    Notification::assertSentTo($user, VerifyUser::class, function ($notification) use ($user) {

        $this->travelTo(
            now()->addSeconds(config('track.login_code.expires_after') + 10)
        );

        $response = $this->post(route('verify.user', [
            'email' => $user->email,
            'code' => $notification->code
        ]));

        $this->assertGuest();
        return true;
    });
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/login');
});
