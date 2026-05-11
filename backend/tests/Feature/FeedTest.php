<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedTest extends TestCase
{
    use RefreshDatabase;

    protected function createArticle(User $user, array $overrides = []): Article
    {
        return Article::create(array_merge([
            'user_id' => $user->id,
            'category_id' => null,
            'type' => 'outfit',
            'title' => 'Article test',
            'description' => 'Description',
            'image' => 'images/article-placeholder.svg',
            'tags' => null,
            'is_published' => true,
            'likes_count' => 0,
            'comments_count' => 0,
        ], $overrides));
    }

    public function test_feed_shows_published_articles(): void
    {
        $user = User::factory()->create();
        $this->createArticle($user, ['title' => 'Look publié visible']);

        $response = $this->actingAs($user)->get('/feed');

        $response->assertStatus(200);
        $response->assertSee('Look publié visible', false);
    }

    public function test_feed_hides_unpublished_articles(): void
    {
        $user = User::factory()->create();
        $this->createArticle($user, ['title' => 'Publié OK', 'is_published' => true]);
        $this->createArticle($user, ['title' => 'Brouillon secret', 'is_published' => false]);

        $response = $this->actingAs($user)->get('/feed');

        $response->assertStatus(200);
        $response->assertSee('Publié OK', false);
        $response->assertDontSee('Brouillon secret', false);
    }

    public function test_feed_pagination_works(): void
    {
        $user = User::factory()->create();
        for ($i = 1; $i <= 16; $i++) {
            $this->createArticle($user, ['title' => sprintf('pagination %02d', $i)]);
        }

        $page1 = $this->actingAs($user)->get('/feed');
        $page1->assertStatus(200);
        $page1->assertSee('pagination 16', false);
        $page1->assertSee('pagination 02', false);
        $page1->assertDontSee('pagination 01', false);

        $page2 = $this->actingAs($user)->get('/feed?page=2');
        $page2->assertStatus(200);
        $page2->assertSee('pagination 01', false);
    }

    public function test_search_returns_matching_articles(): void
    {
        $user = User::factory()->create();
        $this->createArticle($user, ['title' => 'Manteau doré unique', 'description' => 'Hiver']);

        $response = $this->actingAs($user)->get('/search?search=doré');

        $response->assertStatus(200);
        $response->assertSee('Manteau doré unique', false);
    }

    public function test_search_returns_empty_message_when_no_match(): void
    {
        $user = User::factory()->create();
        $this->createArticle($user, ['title' => 'Sans rapport']);

        $response = $this->actingAs($user)->get('/search?search=xyznonexistent999');

        $response->assertStatus(200);
        $response->assertSee('Aucun article trouvé', false);
    }

    public function test_home_page_displays_for_guests(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Trendora', false);
    }

    public function test_authenticated_user_redirected_from_home_to_feed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect('/feed');
    }
}
