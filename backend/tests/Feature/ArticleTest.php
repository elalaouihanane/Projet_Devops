<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_article(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Haut',
            'slug' => 'haut',
            'icon' => null,
        ]);

        $response = $this->actingAs($user)->post('/articles', [
            'title' => 'Mon premier look',
            'type' => 'outfit',
            'category_id' => $category->id,
            'description' => 'Description',
            'occasion' => 'Soirée',
            'color' => 'Noir',
            'image' => UploadedFile::fake()->create('look.jpg', 100, 'image/jpeg'),
            'tags' => ['streetwear', 'chic'],
            'is_published' => 1,
        ]);

        $response->assertRedirect('/articles');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('articles', [
            'user_id' => $user->id,
            'title' => 'Mon premier look',
            'type' => 'outfit',
            'category_id' => $category->id,
        ]);

        $article = Article::firstOrFail();
        Storage::disk('public')->assertExists($article->image);
    }

    public function test_user_cannot_create_article_without_auth(): void
    {
        Storage::fake('public');

        $response = $this->post('/articles', [
            'title' => 'Sans auth',
            'type' => 'outfit',
            'image' => UploadedFile::fake()->image('x.jpg'),
        ]);

        $response->assertRedirect('/login');
    }

    public function test_user_can_edit_own_article(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Chaussures',
            'slug' => 'chaussures',
            'icon' => null,
        ]);

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'clothing',
            'title' => 'Avant',
            'description' => null,
            'occasion' => null,
            'color' => 'Beige',
            'image' => 'articles/old.jpg',
            'tags' => ['tag1'],
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->put("/articles/{$article->id}", [
            'title' => 'Après',
            'type' => 'clothing',
            'category_id' => $category->id,
            'description' => 'Nouvelle description',
            'occasion' => 'Casual',
            'color' => 'Noir',
            'tags' => ['tag1', 'tag2'],
            'is_published' => 1,
        ]);

        $response->assertRedirect("/articles/{$article->id}");
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Après',
            'color' => 'Noir',
        ]);
    }

    public function test_user_cannot_edit_others_article(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $category = Category::create([
            'name' => 'Pantalon',
            'slug' => 'pantalon',
            'icon' => null,
        ]);

        $article = Article::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'type' => 'outfit',
            'title' => 'Article owner',
            'description' => null,
            'occasion' => null,
            'color' => null,
            'image' => 'articles/a.jpg',
            'tags' => null,
            'is_published' => true,
        ]);

        $this->actingAs($other)->get("/articles/{$article->id}/edit")->assertForbidden();

        $this->actingAs($other)->put("/articles/{$article->id}", [
            'title' => 'Hack',
            'type' => 'outfit',
            'category_id' => $category->id,
        ])->assertForbidden();
    }

    public function test_user_can_delete_own_article(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Robe',
            'slug' => 'robe',
            'icon' => null,
        ]);

        Storage::disk('public')->put('articles/to-delete.jpg', 'fake');

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'outfit',
            'title' => 'À supprimer',
            'description' => null,
            'occasion' => null,
            'color' => null,
            'image' => 'articles/to-delete.jpg',
            'tags' => null,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->delete("/articles/{$article->id}");
        $response->assertRedirect('/articles');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
        Storage::disk('public')->assertMissing('articles/to-delete.jpg');
    }

    public function test_article_page_displays(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Accessoires',
            'slug' => 'accessoires',
            'icon' => null,
        ]);

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'clothing',
            'title' => 'Ceinture',
            'description' => 'Desc',
            'occasion' => null,
            'color' => 'Noir',
            'image' => 'articles/x.jpg',
            'tags' => ['minimal'],
            'is_published' => true,
        ]);

        $this->actingAs($user)->get('/articles')->assertOk();
        $this->actingAs($user)->get("/articles/{$article->id}")->assertOk();
        $this->actingAs($user)->get("/articles/{$article->id}/edit")->assertOk();
        $this->actingAs($user)->get('/articles/create')->assertOk();
    }

    public function test_article_requires_title_and_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/articles', [
            'type' => 'outfit',
            'is_published' => 1,
        ]);

        $response->assertSessionHasErrors(['title', 'image']);
    }
}

