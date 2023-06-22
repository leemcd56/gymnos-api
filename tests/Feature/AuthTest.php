<?php

use App\Models\User;

it('can accept user registrations', function () {
    $response = $this->post('/rest/auth/register', [
        'username'              => 'fancynancy',
        'email'                 => 'nancy.picklefeet@example.com',
        'password'              => '*Dev@2023',
        'password_confirmation' => '*Dev@2023',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => __('auth.pending'),
        ]);

    $this->assertDatabaseHas('users', [
        'username' => 'fancynancy',
        'email'    => 'nancy.picklefeet@example.com',
    ]);
});

it('can accept a login request from an unapproved user', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->post('/rest/auth/login', [
        'email'       => $user->email,
        'password'    => 'password',
        'device_name' => 'Pest',
    ]);

    $response->assertStatus(400)
        ->assertJson([
            'message' => __('auth.pending'),
        ])
        ->assertJsonStructure([
            'message',
            'status',
            'data',
        ]);
});

it('can accept a login request from an approved user', function () {
    $user = User::factory()->create();

    $response = $this->post('/rest/auth/login', [
        'email'       => $user->email,
        'password'    => 'password',
        'device_name' => 'Pest',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => __('auth.success'),
        ])
        ->assertJsonStructure([
            'message',
            'status',
            'data',
        ]);
});
