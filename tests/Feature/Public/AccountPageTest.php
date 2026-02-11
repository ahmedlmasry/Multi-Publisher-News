<?php

namespace Tests\Feature\Public;
use App\Models\Post;
use Tests\TestCase;

class AccountPageTest extends TestCase
{
    public function test_account_page_is_accessible()
    {
        $this->actingAs($this->createUser());
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.dashboard.profile');
    }
    public function test_account_page_is_not_accessible_without_login()
    {
        $response = $this->get('/account/profile');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
    public function test_account_page_has_profile_tab()
    {
        $this->actingAs($this->createUser());
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        $response->assertSeeText('Profile');
    }
    public function test_account_page_has_setting_tab()
    {
        $this->actingAs($this->createUser());
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        $response->assertSeeText('Setting');
    }
    public function test_account_page_has_notification_tab()
    {
        $this->actingAs($this->createUser());
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        $response->assertSeeText('Notification');
    }
    public function test_account_page_has_logout_button()
    {
        $this->actingAs($this->createUser());
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        $response->assertSeeText('Logout');
    }
    public function test_account_page_has_add_post_section()
    {
        $this->actingAs($this->createUser());
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        $response->assertSeeText('Add Post');
    }
    public function test_account_page_has_recent_posts_section()
    {
        $this->actingAs($this->createUser());
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        $response->assertSeeText('Recent Posts');
    }

    public function test_account_page_has_post_title_field()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        $posts = Post::factory()->count(5)->create([
            'user_id' => $user->id,
            'status' => 1,
        ]);
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }
        $response->assertSee('class="post-title"', false);
    }
    public function test_account_page_has_post_image_field()
    {
        $this->actingAs($this->createUser());
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        $response->assertSee('id="postImage"', false);
    }
    public function test_account_page_has_post_category_field()
    {
        $this->actingAs($this->createUser());
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        $response->assertSee('id="postCategory"', false);
    }
    public function test_account_page_has_post_button()
    {
        $this->actingAs($this->createUser());
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        $response->assertSee('id="postButton"', false);
    }
    public function test_account_page_has_post_comment_field()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        $posts = Post::factory()->count(5)->create([
            'user_id' => $user->id,
            'status' => 1,
        ]);
        $response = $this->get('/account/profile');
        $response->assertStatus(200);
        foreach ($posts as $post) {
            $response->assertSee('id="commentbtn_' . $post->id . '"', false);
        }
    }
    
   
}
