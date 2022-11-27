<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = User::where('email', 'admin@gmail.com')->first();
        if (is_null($email)) {
            $user = new User();
            $user->name = 'Admin';
            $user->email = 'admin@gmail.com';
            $user->password = Hash::make('admin123');
            $user->status = 1;
            $user->save();
            $user->assignRole('ডেভেলপার');
        }
    }
}
