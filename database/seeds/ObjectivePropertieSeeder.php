<?php

use App\ObjectivePropertie;
use Illuminate\Database\Seeder;

class ObjectivePropertieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objetivies_propertie = [
            ['Venda', 'sale', 1],
            ['Locação', 'location', 1],
        ];

        foreach ($objetivies_propertie as $objetivies_property) {
            ObjectivePropertie::create([
                'name' => $objetivies_property[0],
                'slug' => $objetivies_property[1],
                'active' => $objetivies_property[2],
            ]);
        }
    }
}
