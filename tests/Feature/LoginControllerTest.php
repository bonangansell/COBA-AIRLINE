<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user; // Definisikan properti $user

    protected function setUp(): void
    {
        parent::setUp();

        // Menambahkan user untuk tes login
        $this->user = User::factory()->create([
            'email' => 'user@gmail.com',
            'password' => bcrypt('password')
        ]);
    }

    public function test_login_page_is_accessible()
    {
        // Mengakses halaman login dan memeriksa apakah berhasil
        $response = $this->get(route('login'));

        // Memastikan halaman login dapat diakses
        $response->assertStatus(200);
        $response->assertViewIs('login');
    }

    public function test_login_with_valid_credentials()
    {
        // Data login yang valid
        $data = [
            'email' => 'user@gmail.com',
            'password' => 'password'
        ];

        // Login sebagai user yang sudah ada
        $this->actingAs($this->user);

        // Melakukan request login
        $response = $this->post(route('login.post'), $data);

        // Memastikan berhasil login dan diarahkan ke halaman yang tepat
        $response->assertRedirect('/');
        $response->assertSessionHasNoErrors();
        $this->assertTrue(Auth::check());  // Memastikan user ter-autentikasi
    }

    public function test_login_with_invalid_credentials()
    {
        // Data login yang salah
        $data = [
            'email' => 'user2@gmail.com',
            'password' => 'wrongpassword'
        ];

        // Melakukan request login
        $response = $this->post(route('login.post'), $data);


        // Memastikan login gagal dan kembali ke halaman login dengan error
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Username atau password salah.');
        $this->assertFalse(Auth::check());  // Memastikan user tidak ter-autentikasi
    }

    public function test_login_validation_fails_with_empty_fields()
    {
        // Data login dengan field kosong
        $data = [
            'email' => '',
            'password' => ''
        ];

        // Melakukan request login
        $response = $this->post(route('login.post'), $data);

        // Memastikan ada error validasi
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_login_validation_fails_with_invalid_email_format()
    {
        // Data login dengan format email yang salah
        $data = [
            'email' => 'invalidemail',
            'password' => 'password123'
        ];

        // Melakukan request login
        $response = $this->post(route('login.post'), $data);

        // Memastikan ada error validasi pada email
        $response->assertSessionHasErrors('email');
    }

    public function test_logout_successfully()
    {
        // Login terlebih dahulu untuk memastikan user ter-autentikasi
        $this->actingAs($this->user);

        // Melakukan request logout
        $response = $this->post(route('logout'));

        // Memastikan user logout dan diarahkan ke halaman login
        $response->assertRedirect(route('login'));
        $this->assertFalse(Auth::check());  // Memastikan user tidak ter-autentikasi
    }

}
