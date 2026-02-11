<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }
    public function test_login_page_has_login_button()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    }
    public function test_login_page_has_forgot_password_button()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Forgot Your Password?');
    }
    public function test_login_page_has_email_field()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('email');
    }
    public function test_login_page_has_password_field()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('password');
    }
    public function test_login_page_has_remember_me_field()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Remember Me');
    }
    public function test_login_page_has_login_button_with_route()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    }
    public function test_login_page_has_login_success()
    {
        $user = $this->createUser();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertRedirect('/home');
    }
    public function test_login_page_has_login_failure()
    {
        $user = $this->createUser();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertRedirect('/');
    }
    public function test_login_page_has_login_failure_with_empty_fields()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertRedirect('/');
    }
    public function test_login_page_has_login_success_with_all_fields_and_redirect_to_home_page()
    {
        $user = $this->createUser();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertRedirect('/home');
        $response->assertSessionHas('success', 'You Login Successfully!');
    }

}
