<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_displays(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Créer votre compte');
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Marie',
            'last_name' => 'Dupont',
            'email' => 'marie@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/feed');
        $this->assertDatabaseHas('users', [
            'email' => 'marie@example.com',
            'name' => 'Marie Dupont',
        ]);
    }

    public function test_login_page_displays(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Se connecter');
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/feed');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_register_validates_required_fields(): void
    {
        $response = $this->post('/register', []);
        
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_register_validates_email_unique(): void
    {
        User::factory()->create(['email' => 'test@example.com']);
        
        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        
        $response->assertSessionHasErrors(['email']);
    }

    public function test_register_validates_password_min_length(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);
        
        $response->assertSessionHasErrors(['password']);
    }

    public function test_register_uploads_photo(): void
    {
        Storage::fake('public');
        
        // Image PNG factice (1x1 pixel transparent) — contourne le manque de GD
        $tempFile = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($tempFile, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg=='));
        
        $file = new UploadedFile(
            $tempFile,
            'avatar.png',
            'image/png',
            null,
            true // test mode
        );
        
        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'photo' => $file,
        ]);
        
        $response->assertRedirect('/feed');
        Storage::disk('public')->assertExists('profiles/' . $file->hashName());
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('correctpassword'),
        ]);
        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);
        
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_unauthenticated_user_cannot_access_feed(): void
    {
        $response = $this->get('/feed');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_feed(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/feed');
        $response->assertStatus(200);
    }
}