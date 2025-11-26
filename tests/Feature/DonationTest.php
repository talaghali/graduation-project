<?php

use App\Models\Donation;

// Donation Page Tests
test('donate page displays successfully', function () {
    $response = $this->get(route('donate'));
    $response->assertStatus(200);
    $response->assertSee('Donate');
});

test('donate page shows only paypal payment option', function () {
    $response = $this->get(route('donate'));
    $response->assertStatus(200);
    $response->assertSee('PayPal');
    $response->assertDontSee('Stripe');
    $response->assertDontSee('Credit Card');
});

// Donation Model Tests
test('donation has correct payment method enum', function () {
    expect(Donation::query()->getModel()->getCasts())->toHaveKey('payment_method');
});

test('donation can be created with valid data', function () {
    $donation = Donation::create([
        'donor_name' => 'John Doe',
        'donor_email' => 'john@example.com',
        'amount' => 50.00,
        'currency' => 'USD',
        'payment_method' => 'paypal',
        'status' => 'completed',
        'transaction_id' => 'TEST123456',
        'paypal_payment_id' => 'PAYPAL123',
    ]);

    expect($donation->donor_name)->toBe('John Doe');
    expect($donation->amount)->toBe(50.00);
    expect($donation->payment_method)->toBe('paypal');
});

test('donation belongs to correct payment method', function () {
    $donation = Donation::factory()->create([
        'payment_method' => 'paypal',
    ]);

    expect($donation->payment_method)->toBe('paypal');
});

// Dashboard Donation Tests
test('admin can view donations index', function () {
    $admin = \App\Models\User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
        ->get(route('dashboard.donations.index'));

    $response->assertStatus(200);
});

test('regular user cannot access donations dashboard', function () {
    $user = \App\Models\User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)
        ->get(route('dashboard.donations.index'));

    $response->assertStatus(403);
});

test('donations index shows statistics', function () {
    $admin = \App\Models\User::factory()->create(['role' => 'admin']);

    Donation::factory()->count(5)->create([
        'status' => 'completed',
        'amount' => 100,
    ]);

    $response = $this->actingAs($admin)
        ->get(route('dashboard.donations.index'));

    $response->assertStatus(200);
    $response->assertSee('PayPal Donations');
});

test('admin can view individual donation', function () {
    $admin = \App\Models\User::factory()->create(['role' => 'admin']);

    $donation = Donation::factory()->create([
        'donor_name' => 'Test Donor',
        'amount' => 100,
    ]);

    $response = $this->actingAs($admin)
        ->get(route('dashboard.donations.show', $donation));

    $response->assertStatus(200);
    $response->assertSee('Test Donor');
});

test('donation statistics are calculated correctly', function () {
    Donation::factory()->count(3)->create([
        'payment_method' => 'paypal',
        'status' => 'completed',
        'amount' => 100,
    ]);

    Donation::factory()->count(2)->create([
        'payment_method' => 'paypal',
        'status' => 'pending',
        'amount' => 50,
    ]);

    $completedAmount = Donation::where('status', 'completed')->sum('amount');
    $pendingCount = Donation::where('status', 'pending')->count();

    expect($completedAmount)->toBe(300.0);
    expect($pendingCount)->toBe(2);
});
