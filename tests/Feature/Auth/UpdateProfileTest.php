<?php

namespace Tests\Feature\Auth;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    public function test_update_profile_page_is_accessible()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.dashboard.setting');
    }
    public function test_update_profile_page_has_update_profile_button()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertSee('Save Changes');
    }
    public function test_update_profile_page_has_name_field()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertSee('name');
    }
    public function test_update_profile_page_has_email_field()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertSee('email');
    }
    public function test_update_profile_page_has_password_field()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertSee('password');
    }
    public function test_update_profile_page_has_password_confirmation_field()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertSee('password_confirmation');
    }
    public function test_update_profile_page_has_update_profile_button_with_route()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user);
        $response = $this->get('/account/setting');
        $response->assertStatus(200);
        $response->assertSee('Save Changes');
    }
    public function test_update_profile_page_has_update_profile_success_with_all_fields()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->from('/account/setting')
            ->put('/account/setting', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'username' => 'johndoe_unique',
                'phone' => '0123456789',
                'country' => 'Egypt',
                'city' => 'Cairo',
                'street' => 'Short Street',
                'image' => UploadedFile::fake()->image('avatar.jpg'),
            ]);
        $response->assertSessionHas('Success', 'Profile Updated Successfully!');
        $response->assertRedirect('/account/setting');
    }

    public function test_update_profile_page_has_update_profile_failure_with_empty_fields()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->from('/account/setting')
            ->put('/account/setting', [
                'name' => '',
                'email' => '',
                'username' => '',
                'phone' => '',
                'country' => '',
                'city' => '',
                'street' => '',
            ]);
        $response->assertSessionHasErrors(['name', 'email', 'username', 'phone', 'country', 'city', 'street']);
        $response->assertRedirect('/account/setting');
    }
    public function test_update_profile_page_has_update_profile_failure_with_too_short_fields()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->from('/account/setting')
            ->put('/account/setting', [
                'name' => 'a',
                'email' => 'invalid-email',
                'username' => 'u',
                'phone' => 'abc',
                'country' => 'c',
                'city' => 'c',
                'street' => 's',
            ]);
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'country', 'city', 'street']);
        $response->assertRedirect('/account/setting');
    }
    public function test_update_profile_page_has_update_profile_failure_with_too_long_fields()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->from('/account/setting')
            ->put('/account/setting', [
                'name' => str_repeat('a', 61),
                'email' => 'john@example.com',
                'username' => 'johndoe',
                'phone' => '0123456789',
                'country' => str_repeat('a', 21),
                'city' => str_repeat('a', 21),
                'street' => str_repeat('a', 31),
            ]);
        $response->assertSessionHasErrors(['name', 'country', 'city', 'street']);
        $response->assertRedirect('/account/setting');
    }
}
