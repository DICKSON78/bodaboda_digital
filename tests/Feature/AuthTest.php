<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    public function test_register_page_loads()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_login_page_loads()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'TestRegisterUser',
            'email' => 'testregister@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '+256700000010',
            'role' => 'passenger',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'testregister@example.com',
        ]);
    }

    public function test_user_can_login()
    {
        User::factory()->create([
            'email' => 'testlogin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'testlogin@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
    }

    public function test_login_fails_with_wrong_password()
    {
        User::factory()->create([
            'email' => 'testloginfail@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'testloginfail@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
