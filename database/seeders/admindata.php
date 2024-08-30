<?php

namespace Database\Seeders;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class admindata extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $admin = [
        'name' => 'Admin',
        'email' => 'Admin@123',
        'password' =>bcrypt(12345),
        'Login_at' => date('Y-m-d H:i:s'),
        ];

        admin::create($admin);

        $superadmin = [
            'name' => 'Superadmin',
            'email' => 'Superadmin@123',
            'password' =>bcrypt(12345),
            'Login_at' => date('Y-m-d H:i:s'),
        ];
        admin::create($superadmin);
    }
}
