<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_registration_from_login(): void
    {
        $this->get('/login')->assertSee(route('register'));
        $this->get('/registro')->assertOk()->assertSee('Crear mi cuenta');
    }

    public function test_registration_creates_account_with_hashed_password_and_logs_in(): void
    {
        $this->post('/registro', [
            'name' => 'Ana Pérez', 'email' => 'ana@example.com',
            'password' => 'ClaveSegura123!', 'password_confirmation' => 'ClaveSegura123!',
        ])->assertRedirect('/dashboard')->assertSessionHasNoErrors();

        $user = User::where('email', 'ana@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('ClaveSegura123!', $user->password));
        $this->assertAuthenticatedAs($user);
        $this->post('/logout');
        $this->post('/login', ['email' => $user->email, 'password' => 'ClaveSegura123!'])
            ->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_duplicate_email_and_mismatched_password_are_rejected(): void
    {
        $user = User::factory()->create();
        $this->post('/registro', [
            'name' => 'Otra persona', 'email' => $user->email,
            'password' => 'ClaveSegura123!', 'password_confirmation' => 'OtraClave123!',
        ])->assertSessionHasErrors(['email', 'password']);
        $this->assertDatabaseCount('users', 1);
        $this->assertGuest();
    }

    public function test_required_fields_and_short_password_are_rejected(): void
    {
        $this->post('/registro', [])->assertSessionHasErrors(['name', 'email', 'password']);
        $this->post('/registro', [
            'name' => 'Ana', 'email' => 'ana@example.com',
            'password' => '123', 'password_confirmation' => '123',
        ])->assertSessionHasErrors('password');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_signed_in_users_cannot_register_another_account(): void
    {
        $this->actingAs(User::factory()->create())->get('/registro')->assertRedirect('/dashboard');
        $this->post('/registro', [])->assertRedirect('/dashboard');
        $this->assertDatabaseCount('users', 1);
    }
}
