<?php

use App\Models\Company;
use Illuminate\Auth\Events\Registered;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {

    Event::fake();

    $email = 'test@example.com';

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => $email,
        'phone' => '1231231234',
        'company_id' => Company::factory()->create()->getKey()
    ]);

    Event::assertDispatched(Registered::class);

    $response->assertRedirect(route('verification.notice', ['email' => $email]));
});
