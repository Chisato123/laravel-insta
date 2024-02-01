<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            [
                'name' => 'User30',
                'email' => 'user30@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'User31',
                'email' => 'user31@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'User32',
                'email' => 'user32@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->user->insert($users);
    }
}
