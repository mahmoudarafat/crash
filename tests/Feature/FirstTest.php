<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});


it('is up', function () { // any response is valid [ home needs auth so 302 if not authenticated ] 
    $this->get("/home")->assertStatus(302); // landing page is alive
});

it('can go home if authenticated', function () {
    $this->actingAs($this->user);
    $this->get("/home")->assertStatus(200); // continue
});


it('can not go home if not authenticated', function () {
    $this->get("/home")->assertStatus(302); // redireect login
});

// it('opens landing page with authinticated menu', function(){
//     $this->actingAs($this->user);
//     $this->get('/')->assertSeeText(['My Books', 'Add A Book', 'Friends']);
// });


// it('opens landing page with guest menu', function(){
//     $this->get('/')->assertSeeText(['welcome to our landing page.', 'Login, Please.']);
// });

