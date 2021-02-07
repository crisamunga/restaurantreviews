<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
            'name' => 'Admin',
            'password' => '00000000',
            'email' => 'admin@example.com',
            'is_owner' => true,
        ]);
        $user->is_admin = true;
        $user->save();
    }
}
