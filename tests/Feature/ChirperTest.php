<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Chirp;   //Use model : Chirp
use App\Models\User;    //Use model : User
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\UserFactory; //Use factory : UserFactory

class ChirperTest extends TestCase
{
    use RefreshDatabase;

    //Testnya Memakai Format PHPUnit

    //Test 1 - Tes Halaman Utama
    public function test__1_halaman_utama()
    {
        $response = $this->get('/'); //Mengakses halaman utama

        $response->assertStatus(200); //Memastikan status respons adalah 200 (OK)
        $response->assertSee('Chirper'); //Memastikan halaman mengandung teks "Chirper"
    }

    //Test 2 - Tes Login Pengguna
    public function test__2_login_pengguna()
    {
        $user = User::factory()->create(); //Membuat pengguna baru menggunakan factory

        $response = $this->actingAs($user)->get('/'); //Mengakses halaman utama sebagai pengguna yang sudah login

        $response->assertStatus(200); //Memastikan status respons adalah 200 (OK)
        $response->assertSee($user->name); //Memastikan halaman mengandung nama pengguna yang sudah login
    }

    //Test 3 - Tes Membuat Chirp Baru
    public function test__3_membuat_chirp_baru()
    {
        $user = User::factory()->create(); //Membuat pengguna baru menggunakan factory

        $response = $this->actingAs($user)->post('/chirps', [ //Mengirim permintaan POST untuk membuat chirp baru
            'message' => 'Ini adalah chirp baru!', //Isi pesan chirp
        ]);

        $response->assertStatus(302); //Memastikan status respons adalah 302 (Redirect)
        $response->assertRedirect('/'); //Memastikan pengguna diarahkan kembali ke halaman utama
    }
}
