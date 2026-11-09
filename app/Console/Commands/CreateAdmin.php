<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'motocheck:make-admin {email} {name}';

    protected $description = 'Buat atau promosikan akun administrator MotoCheck';

    public function handle(): int
    {
        $email = $this->argument('email');
        $name = $this->argument('name');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->components->error('Alamat email tidak valid.');

            return self::FAILURE;
        }

        $password = $this->secret('Masukkan kata sandi admin (minimal 10 karakter)');

        if (! is_string($password) || strlen($password) < 10) {
            $this->components->error('Kata sandi harus memiliki minimal 10 karakter.');

            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password), 'role' => 'admin'],
        );

        $this->components->info("Akun administrator {$user->email} siap digunakan.");

        return self::SUCCESS;
    }
}
