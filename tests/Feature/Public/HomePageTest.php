<?php

namespace Tests\Feature\Public;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_is_accessible()
    {
        $response = $this->get('/home');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.index');
        $response->assertSeeText('Popular News');

    }
    public function test_unauthenticated_user_see_login_and_register_buttons()
    {
        $response = $this->get('/home');
        $response->assertStatus(200);
        $response->assertSeeText('Login');
        $response->assertSeeText('Register');
    }
    public function test_unauthenticated_user_see_latest_news()
    {
        $response = $this->get('/home');
        $response->assertStatus(200);
        $response->assertSeeText('Latest News');
    }
    public function test_authenticated_user_see_logout_button()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);
        $response->assertSeeText('Logout');
    }
    public function test_authenticated_user_see_account_button()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);
        $response->assertSeeText('Account');
    }
    public function test_authenticated_user_see_notification_button()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);
       $response->assertSee('id="notificationDropdown"',false);
    }
    public function test_authenticated_user_see_his_name_in_header()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);
       $response->assertSeeText($user->name);
    }
    public function test_authenticated_user_see_his_notification_count_in_header()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);
       $response->assertSeeText($user->unreadNotifications->count());
    }

}
