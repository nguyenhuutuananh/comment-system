<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            array(
                'email' => 'admin@admin.com',
                'name' => 'Tuan Anh',
                'password' => bcrypt('aspirine')
            ),
            array(
                'email' => 'admin2@admin.com',
                'name' => 'Dao Tuan',
                'password' => bcrypt('aspirine')
            ),
        ]);
    }
}
