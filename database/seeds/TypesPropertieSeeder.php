<?php

use App\TypePropertie;
use Illuminate\Database\Seeder;

class TypesPropertieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types_propertie = [
            ['Apartamento', 'apartmant', 1],
            ['Comercial', 'comercial', 1],
            ['Casa Térrea', 'house', 1],
            ['Sobrado', 'soft', 1],
            ['Assobradado', 'haunted', 1],
            ['Terreno', 'ground', 1],
            ['Sitio', 'place', 1],
            ['Chacára', 'farm', 1],
            ['Outros', 'other', 1],
        ];

        foreach ($types_propertie as $type_propertie) {
            TypePropertie::create([
                'name' => $type_propertie[0],
                'slug' => $type_propertie[1],
                'active' => $type_propertie[2],
            ]);
        }
    }
}
