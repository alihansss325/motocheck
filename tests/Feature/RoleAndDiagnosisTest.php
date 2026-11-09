<?php

namespace Tests\Feature;

use App\Models\Diagnosis;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleAndDiagnosisTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_requires_an_admin_account(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));

        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertForbidden();

        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee('Dashboard terhubung')
            ->assertDontSee('Rizky Pratama');
    }

    public function test_public_registration_creates_only_a_user_role(): void
    {
        $this->post('/register', [
            'name' => 'Pengguna MotoCheck',
            'email' => 'pengguna@example.test',
            'password' => 'motocheck-password-123',
            'password_confirmation' => 'motocheck-password-123',
            'role' => 'admin',
        ])->assertRedirect(route('account'));

        $this->assertDatabaseHas('users', [
            'email' => 'pengguna@example.test',
            'role' => 'user',
        ]);
    }

    public function test_users_can_log_in_and_log_out(): void
    {
        $user = User::factory()->create([
            'email' => 'account@example.test',
            'password' => 'motocheck-password-123',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'motocheck-password-123',
        ])->assertRedirect(route('account'));

        $this->get(route('account'))
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee('Kembali ke beranda')
            ->assertSee('Riwayat diagnosa')
            ->assertSee('Pengaturan akun')
            ->assertSee('aria-selected="true"', false);

        $this->post('/logout')->assertRedirect(route('login'));
        $this->get(route('account'))->assertRedirect(route('login'));
    }

    public function test_home_navigation_changes_for_guest_user_and_admin(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Masuk / Daftar')
            ->assertDontSee('Akun saya')
            ->assertDontSee('name="_token"', false);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/')
            ->assertOk()
            ->assertSee('Akun saya')
            ->assertSee('aria-label="Akun saya"', false)
            ->assertSee('Keluar')
            ->assertDontSee('Masuk / Daftar');

        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/')
            ->assertOk()
            ->assertSee('aria-label="Dashboard admin"', false)
            ->assertDontSee('Akun admin')
            ->assertSee('Keluar')
            ->assertDontSee('Masuk / Daftar');
    }

    public function test_admin_account_route_redirects_to_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('account'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_users_can_update_profile_and_change_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('account'))
            ->patch(route('account.profile.update'), [
                'name' => 'Nama Baru',
                'email' => 'nama-baru@example.test',
            ])
            ->assertRedirect(route('account'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
            'email' => 'nama-baru@example.test',
            'email_verified_at' => null,
        ]);

        $this->from(route('account'))
            ->put(route('account.password.update'), [
                'current_password' => 'password',
                'password' => 'new-secure-password-456',
                'password_confirmation' => 'new-secure-password-456',
            ])
            ->assertRedirect(route('account'));

        $this->assertTrue(Hash::check('new-secure-password-456', $user->fresh()->password));

        $this->get(route('account'))
            ->assertOk()
            ->assertSee('id="settings-tab" class="account-tab is-active"', false)
            ->assertSee('Kata sandi berhasil diganti.');
    }

    public function test_users_can_delete_their_account_and_personal_diagnoses(): void
    {
        $user = User::factory()->create();
        $personalDiagnosis = Diagnosis::create([
            'user_id' => $user->id,
            'symptoms' => ['G01'],
            'severity' => 'Sedang',
        ]);
        $anonymousDiagnosis = Diagnosis::create([
            'user_id' => null,
            'symptoms' => ['G04'],
            'severity' => 'Berat',
        ]);

        $this->actingAs($user)
            ->from(route('account'))
            ->delete(route('account.destroy'), [
                'current_password' => 'password',
                'confirm_delete' => '1',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHas('status', 'Akun dan riwayat diagnosa Anda telah dihapus.');

        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('diagnoses', ['id' => $personalDiagnosis->id]);
        $this->assertDatabaseHas('diagnoses', ['id' => $anonymousDiagnosis->id]);
    }

    public function test_admin_cannot_use_user_account_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->patch(route('account.profile.update'), [
                'name' => 'Updated',
                'email' => $admin->email,
            ])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'name' => $admin->name,
        ]);
    }

    public function test_diagnoses_are_saved_for_the_signed_in_user_and_anonymously(): void
    {
        $user = User::factory()->create();

        $this->postJson('/api/diagnoses', ['symptoms' => ['G01', 'G04']])
            ->assertCreated();

        $this->actingAs($user)
            ->postJson('/api/diagnoses', ['symptoms' => ['G01', 'G06']])
            ->assertCreated();

        $this->assertDatabaseCount('diagnoses', 2);
        $this->assertSame(1, Diagnosis::where('user_id', $user->id)->count());
        $this->assertSame('Berat', Diagnosis::whereNull('user_id')->firstOrFail()->severity);
        $this->assertSame('Sedang', $user->diagnoses()->firstOrFail()->severity);
    }

    public function test_diagnosis_rejects_unknown_symptom_codes(): void
    {
        $this->postJson('/api/diagnoses', ['symptoms' => ['G99']])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('symptoms.0');
    }
}
