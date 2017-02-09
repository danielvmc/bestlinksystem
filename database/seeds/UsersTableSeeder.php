<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => '123456',
            'admin' => true,
        ]);

        User::create([
            'name' => 'Nga',
            'username' => 'nga',
            'password' => '123456',
        ]);

        User::create([
            'name' => 'Tuyết',
            'username' => 'tuyet',
            'password' => '123456',
        ]);

        User::create([
            'name' => 'Tâm',
            'username' => 'tam',
            'password' => '123456',
        ]);

        User::create([
            'name' => 'Thanh',
            'username' => 'thanh',
            'password' => '123456',
        ]);

        User::create([
            'name' => 'Thịnh',
            'username' => 'thinh',
            'password' => '123456',
        ]);

        User::create([
            'name' => 'Duyên',
            'username' => 'duyen',
            'password' => '123456',
        ]);

        User::create([
            'name' => 'Phúc',
            'username' => 'phuc',
            'password' => '123456',
        ]);

        User::create([
            'name' => 'Chi',
            'username' => 'chi',
            'password' => '123456',
        ]);

        User::create([
            'name' => 'Vương',
            'username' => 'vuong',
            'password' => '123456',
        ]);
    }
}
