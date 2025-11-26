<?php

use App\Models\Story;
use App\Models\User;

// Home Page Tests
test('home page displays successfully', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

test('home page displays approved stories', function () {
    $user = User::factory()->create();

    Story::factory()->create([
        'user_id' => $user->id,
        'status' => Story::STATUS_APPROVED,
        'name' => 'Test User',
        'title' => 'Test Story',
    ]);

    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('Test Story');
});

test('home page does not display pending stories', function () {
    $user = User::factory()->create();

    Story::factory()->create([
        'user_id' => $user->id,
        'status' => Story::STATUS_PENDING,
        'title' => 'Pending Story',
    ]);

    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertDontSee('Pending Story');
});

test('home page displays statistics', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('Stories Shared');
    $response->assertSee('Contributors from Gaza');
});

// Story Listing Tests
test('stories index page displays approved stories', function () {
    $user = User::factory()->create();

    Story::factory()->count(5)->create([
        'user_id' => $user->id,
        'status' => Story::STATUS_APPROVED,
    ]);

    $response = $this->get(route('stories.index'));
    $response->assertStatus(200);
});

test('story show page displays approved story', function () {
    $user = User::factory()->create();

    $story = Story::factory()->create([
        'user_id' => $user->id,
        'status' => Story::STATUS_APPROVED,
        'title' => 'Visible Story',
    ]);

    $response = $this->get(route('stories.show', $story));
    $response->assertStatus(200);
    $response->assertSee('Visible Story');
});

test('story show page returns 404 for pending story', function () {
    $user = User::factory()->create();

    $story = Story::factory()->create([
        'user_id' => $user->id,
        'status' => Story::STATUS_PENDING,
    ]);

    $response = $this->get(route('stories.show', $story));
    $response->assertStatus(404);
});

// Story Creation Tests
test('authenticated user can access share story page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('share'));
    $response->assertStatus(200);
});

test('unauthenticated user can access share story page', function () {
    $response = $this->get(route('share'));
    $response->assertStatus(200);
});

test('authenticated user can submit a story', function () {
    $user = User::factory()->create();

    $storyData = [
        'title' => 'My Gaza Story',
        'content' => 'This is my story from Gaza...',
        'name' => 'John Doe',
        'age' => 30,
        'location' => 'Gaza City',
        'story_type' => 'Personal Experience',
    ];

    $response = $this->actingAs($user)
        ->postJson(route('stories.store'), $storyData);

    $response->assertStatus(200);
    $response->assertJson(['success' => true]);

    $this->assertDatabaseHas('stories', [
        'title' => 'My Gaza Story',
        'user_id' => $user->id,
        'status' => Story::STATUS_PENDING,
    ]);
});

test('story submission requires title and content', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->postJson(route('stories.store'), []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title', 'content']);
});

// Story Model Tests
test('story model has correct fillable attributes', function () {
    $story = new Story();

    expect($story->getFillable())->toContain('title', 'content', 'name', 'age', 'location');
});

test('story model can check if approved', function () {
    $user = User::factory()->create();

    $approvedStory = Story::factory()->create([
        'user_id' => $user->id,
        'status' => Story::STATUS_APPROVED,
    ]);

    $pendingStory = Story::factory()->create([
        'user_id' => $user->id,
        'status' => Story::STATUS_PENDING,
    ]);

    expect($approvedStory->isApproved())->toBeTrue();
    expect($pendingStory->isApproved())->toBeFalse();
});

test('story model approved scope returns only approved stories', function () {
    $user = User::factory()->create();

    Story::factory()->count(3)->create([
        'user_id' => $user->id,
        'status' => Story::STATUS_APPROVED,
    ]);

    Story::factory()->count(2)->create([
        'user_id' => $user->id,
        'status' => Story::STATUS_PENDING,
    ]);

    $approvedCount = Story::approved()->count();
    expect($approvedCount)->toBe(3);
});
