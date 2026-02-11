<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class SignUpTest extends TestCase
{
    public function test_sign_up_page_is_accessible()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }
    public function test_sign_up_page_has_register_button()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register');
    }
    public function test_sign_up_page_has_name_field()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('name');
    }
    public function test_sign_up_page_has_email_field()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('email');
    }
    public function test_sign_up_page_has_password_field()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('password');
    }
    public function test_sign_up_page_has_password_confirmation_field()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('password_confirmation');
    }
    public function test_sign_up_page_has_register_button_with_route()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register');
    }
    public function test_sign_up_page_has_login_success_with_all_fields()
    {
        $user = $this->createUser();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'wrong-password',
            'password_confirmation' => 'wrong-password',
            'username' => $user->username,
            'phone' => $user->phone,
            'country' => $user->country,
            'city' => $user->city,
            'street' => $user->street,
            'image' => $user->image,
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertRedirect('/');
    }
    public function test_sign_up_page_has_login_failure_with_empty_fields()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertRedirect('/');
    }
    public function test_sign_up_page_has_login_failure_with_wrong_password()
    {
        $user = $this->createUser();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'wrong-password',
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertRedirect('/');
    }
    public function test_sign_up_page_has_login_failure_with_wrong_password_confirmation()
    {
        $user = $this->createUser();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'wrong-password',
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertRedirect('/');
    }
   
}
