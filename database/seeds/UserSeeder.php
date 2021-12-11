<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['Marcos Guilherme', 'marcosguilhermealves@gmail.com', bcrypt('123456')],
            ['ADM', 'adm@sismob.com.br', bcrypt('admin123')],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user[0],
                'email' => $user[1],
                'password' => $user[2],
            ]);
        }
    }
}
