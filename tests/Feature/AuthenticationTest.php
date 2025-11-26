<?php

use App\Models\User;

// Registration Tests
test('registration page displays successfully', function () {
    $response = $this->get(route('signup'));
    $response->assertStatus(200);
});

test('new user can register', function () {
    $response = $this->postJson(route('api.register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['success' => true]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);
});

test('registration requires name', function () {
    $response = $this->postJson(route('api.register'), [
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name']);
});

test('registration requires valid email', function () {
    $response = $this->postJson(route('api.register'), [
        'name' => 'Test User',
        'email' => 'invalid-email',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['email']);
});

test('registration prevents duplicate email', function () {
    User::factory()->create(['email' => 'test@example.com']);

    $response = $this->postJson(route('api.register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['email']);
});

// Login Tests
test('login page displays successfully', function () {
    $response = $this->get(route('login'));
    $response->assertStatus(200);
});

test('user can login with correct credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson(route('api.login'), [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['success' => true]);
    $this->assertAuthenticatedAs($user);
});

test('user cannot login with incorrect password', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson(route('api.login'), [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401);
    $this->assertGuest();
});

// Logout Tests
test('authenticated user can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->postJson(route('api.logout'));

    $response->assertStatus(200);
    $this->assertGuest();
});

// Profile Tests
test('authenticated user can access profile page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('profile'));
    $response->assertStatus(200);
});

test('unauthenticated user cannot access profile page', function () {
    $response = $this->get(route('profile'));
    $response->assertStatus(302);
    $response->assertRedirect(route('login'));
});
