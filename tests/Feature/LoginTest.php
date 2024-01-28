<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


test('user can log in with valid credentials', function () {
    // Create a user with known credentials
    $user = User::factory()->create([
        'email' => 'john@example.com',
        'password' => bcrypt('password123'),
    ]);

    // Attempt to log in with the created user's credentials
    $response = $this->post('/login', [
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/home'); // Adjust the redirect URL based on your application
    $this->assertAuthenticatedAs($user);
});

test('user cannot log in with invalid credentials', function () {
    // Attempt to log in with invalid credentials
    $response = $this->post('/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'invalidpassword',
    ]);

    $response->assertSessionHasErrors(['email']);
    $this->assertGuest(); // Ensure the user is not authenticated
});

test('user is redirected to login page when not authenticated', function () {
    // Visit a page that requires authentication
    $response = $this->get('/home');

    $response->assertRedirect('/login'); // Adjust the redirect URL based on your application
});

test('user can log out', function () {
    // Create a user
    $user = User::factory()->create();

    // Log in the user
    $this->actingAs($user);

    // Log out the user
    $response = $this->post('/logout');

    $response->assertRedirect('/'); // Adjust the redirect URL based on your application
    $this->assertGuest(); // Ensure the user is not authenticated
});
