<?php

namespace Tests\Feature\Auth;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    public function test_change_password_page_is_accessible()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.dashboard.setting');
    }
    public function test_change_password_page_has_change_password_button()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertSee('Change Password');
    }
    public function test_change_password_page_has_password_field()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertSee('password');
    }
    public function test_change_password_page_has_password_confirmation_field()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertSee('password_confirmation');
    }
    public function test_change_password_page_has_change_password_button_with_route()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertSee('Change Password');
    }
    public function test_change_password_page_has_change_password_success_with_all_fields()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->from('/account/setting')
            ->post('/account/setting/change-password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);
        $response->assertSessionHas('Success', 'Your Password Changed Successfully!');
        $response->assertRedirect('/account/setting');
    }
    public function test_change_password_page_has_change_password_failure_with_empty_fields()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->from('/account/setting')
            ->post('/account/setting/change-password', [
                'password' => '',
                'password_confirmation' => '',
            ]);
        $response->assertSessionHasErrors(['password', 'password_confirmation']);
        $response->assertRedirect('/account/setting');
    }
    public function test_change_password_page_has_change_password_failure_with_too_short_fields()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->from('/account/setting')
            ->post('/account/setting/change-password', [
                'current_password' => 'password',
                'password' => 'a',
                'password_confirmation' => 'a',
            ]);
        $response->assertSessionHasErrors('password','password must be at least 8 characters long');
        $response->assertRedirect('/account/setting');
    }
    public function test_change_password_page_has_change_password_failure_with_too_long_fields()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->from('/account/setting')
            ->post('/account/setting/change-password', [
                'current_password' => 'password',
                'password' => str_repeat('a', 61),
                'password_confirmation' => str_repeat('a', 61),
            ]);
        $response->assertSessionHasErrors('password', 'password must be at most 60 characters long');
        $response->assertRedirect('/account/setting');
    }
    public function test_change_password_page_has_change_password_failure_with_wrong_password_confirmation()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->from('/account/setting')
            ->post('/account/setting/change-password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'wrong-password',
            ]);
        $response->assertSessionHasErrors('password','password confirmation does not match');
        $response->assertRedirect('/account/setting');
    }
    public function test_change_password_page_has_change_password_failure_with_wrong_current_password()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->from('/account/setting')
            ->post('/account/setting/change-password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);
        $response->assertSessionHasErrors('current_password','current password is wrong');
        $response->assertRedirect('/account/setting');
    }
    public function test_change_password_page_has_change_password_success_with_all_fields_and_redirect_to_setting_page()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->from('/account/setting')
            ->post('/account/setting/change-password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);
        $response->assertSessionHas('Success', 'Your Password Changed Successfully!');
        $response->assertRedirect('/account/setting');
    }
}
