<?php

use Illuminate\Database\Seeder;
use App\CivilState;

class CivilStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $civil_states = [
            ['Solteiro', 'singer', 1],
            ['Casado', 'married', 1],
            ['Divorciado', 'divorced', 1],
            ['Viúvo', 'widower', 1],
        ];

        foreach ($civil_states as $state) {
            CivilState::create([
                'name' => $state[0],
                'slug' => $state[1],
                'active' => $state[2],
            ]);
        }
    }
}
