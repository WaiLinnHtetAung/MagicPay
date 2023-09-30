<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_users = [
            [
                'id'        => 1,
                'name'      => 'wailinn',
                'email'     => 'wailinn@gmail.com',
                'phone'     => '09440036782',
                'password'  => bcrypt('password'),
            ],
        ];

        AdminUser::insert($admin_users);
    }
}
