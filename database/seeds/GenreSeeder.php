<?php

use Illuminate\Database\Seeder;
use App\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = [
            ['Masculino', 'male', 1],
            ['Feminino', 'female', 1],
            ['Outros', 'others', 1]
        ];

        foreach ($genres as $genre) {
            Genre::create([
                'name' => $genre[0],
                'slug' => $genre[1],
                'active' => $genre[2],
            ]);
        }
    }
}
