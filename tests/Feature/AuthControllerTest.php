<?php

namespace Tests\Feature;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_success()
    {
        $this->mock(AuthService::class, function ($mock) {
            $mock->shouldReceive('register')
                ->once()
                ->andReturn([
                    'message' => 'User registered successfully',
                    'user' => [
                        'id' => 1,
                        'name' => 'nika kaulashvili',
                        'email' => 'nika@nika.com',
                    ],
                ]);
        });

        $response = $this->postJson('/api/register', [
            'name' => 'nika kaulashvili',
            'email' => 'nika@nika.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'user' => [
                'id',
                'name',
                'email',
            ],
        ]);
    }

    public function test_login_success()
    {
        $this->mock(AuthService::class, function ($mock) {
            $mock->shouldReceive('login')
                ->once()
                ->andReturn([
                    'token' => 'sample-jwt-token',
                    'user' => [
                        'id' => 1,
                        'name' => 'nika kaulashvili',
                        'email' => 'nika@nika.com',
                    ],
                ]);
        });

        $response = $this->postJson('/api/login', [
            'email' => 'nika@nika.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
            'user' => [
                'id',
                'name',
                'email',
            ],
        ]);
    }

    public function test_login_failure()
    {
        $authServiceMock = $this->mock(AuthService::class, function ($mock) {
            $mock->shouldReceive('login')
                ->once()
                ->andReturn([
                    'error' => 'Invalid credentials',
                    'status' => 401,
                ]);
        });

        $response = $this->postJson('/api/login', [
            'email' => 'wrongemail@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Invalid credentials',
        ]);
    }
}
