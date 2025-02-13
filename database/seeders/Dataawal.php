<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class Dataawal extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User ();
        $user->name = 'Admin';
        $user->email = 'adminkasir@gmail.com';
        $user->password = bcrypt('12345');
        $user->peran = 'Admin';
        $user->save();

        $user = new User ();
        $user->name = 'Kasir';
        $user->email = 'kasir@gmail.com';
        $user->password = bcrypt('123321');
        $user->peran = 'Kasir';
        $user->save();
    }
}
