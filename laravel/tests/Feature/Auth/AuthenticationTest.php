<?php

use Livewire\Volt\Volt;
use Modules\Xot\Datas\XotData;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertOk()->assertSeeVolt('pages.auth.login');
});

test('users can authenticate using the login screen', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $component = Volt::test('pages.auth.login')->set('form.email', $user->email)->set('form.password', 'password');

    $component->call('login');

    $component->assertHasNoErrors()->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $component = Volt::test('pages.auth.login')->set('form.email', $user->email)->set(
        'form.password',
        'wrong-password',
    );

    $component->call('login');

    $component->assertHasErrors()->assertNoRedirect();

    $this->assertGuest();
});

test('navigation menu can be rendered', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/dashboard');

    $response->assertOk()->assertSeeVolt('layout.navigation');
});

test('users can logout', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $this->actingAs($user);

    $component = Volt::test('layout.navigation');

    $component->call('logout');

    $component->assertHasNoErrors()->assertRedirect('/');

    $this->assertGuest();
});
