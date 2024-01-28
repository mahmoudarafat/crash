<?php


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can register with valid data', function () {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->post('/register', $userData);

    $response->assertRedirect('/home');
    $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
});

test('user cannot register with invalid data', function () {
    $response = $this->post('/register', [
        'name' => '',
        'email' => 'email@email.com',
        'password' => 'short',
        'password_confirmation' => 'mismatch',
    ]);
    // $response->assertSessionHasErrors(['name', 'email', 'password']);
    
    $response->assertSessionHasErrors(['name', 'password']); // Check only for specific fields

    $errors = session('errors')->getBag('default')->toArray();

    // Ensure that errors exist for the specified fields, but not for all fields
    $this->assertArrayHasKey('name', $errors);
    $this->assertArrayHasKey('password', $errors);
    $this->assertArrayNotHasKey('email', $errors);
   
    $this->assertDatabaseCount('users', 0); // Ensure no user is created
});

test('user cannot register with existing email', function () {
    // Create a user with the specified email
    User::factory()->create(['email' => 'existing@example.com']);

    $response = $this->post('/register', [
        'name' => 'New User',
        'email' => 'existing@example.com', // This email already exists
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertDatabaseCount('users', 1); // Ensure only the existing user is present
});
