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
        $email = 'testregister_' . uniqid() . '@example.com';
        $token = 'reg_token_' . uniqid();
        $this->withSession(['_token' => $token]);

        $response = $this->post('/register', [
            '_token' => $token,
            'name' => 'TestRegisterUser',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '+256700000010',
            'role' => 'passenger',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }

    public function test_user_can_login()
    {
        $email = 'testlogin_' . uniqid() . '@example.com';
        $token = 'login_token_' . uniqid();
        $this->withSession(['_token' => $token]);

        User::factory()->create([
            'email' => $email,
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            '_token' => $token,
            'email' => $email,
            'password' => 'password123',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
    }

    public function test_login_fails_with_wrong_password()
    {
        $email = 'testloginfail_' . uniqid() . '@example.com';
        $token = 'fail_token_' . uniqid();
        $this->withSession(['_token' => $token]);

        User::factory()->create([
            'email' => $email,
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            '_token' => $token,
            'email' => $email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
