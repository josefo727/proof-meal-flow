<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $recipes = [
            [
                'name' => 'Arroz con tomate',
                'description' => 'Un reconfortante tazón de arroz esponjoso cubierto con tomates frescos cortados en cubitos, cebollas salteadas y queso derretido para una comida deliciosa y satisfactoria.',
                'ingredients' => json_encode(['rice', 'tomato', 'onion', 'cheese']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Delicia de pollo al limón',
                'description' => 'Jugoso pollo marinado en una sabrosa mezcla de limón y cebolla, luego asado a la perfección para obtener un plato refrescante y sabroso.',
                'ingredients' => json_encode(['chicken', 'lemon', 'onion']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tarta de patatas con queso',
                'description' => 'Unas cremosas patatas asadas cubiertas de queso pegajoso y cebolla caramelizada las convierten en el acompañamiento perfecto o en una contundente opción vegetariana.',
                'ingredients' => json_encode(['potato', 'cheese', 'onion']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Albóndigas con salsa de tomate',
                'description' => 'Sabrosas albóndigas hechas de carne picada mezclada con cebolla y recubiertas de una salsa de tomate ácida, servidas como aperitivo o sobre arroz.',
                'ingredients' => json_encode(['meat', 'ketchup', 'onion']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Wraps de lechuga con pollo',
                'description' => 'Tierno pollo salteado con cebolla y servido en crujientes hojas de lechuga para una comida ligera y sana fácil de comer.',
                'ingredients' => json_encode(['chicken', 'lettuce', 'onion']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Buñuelos de patata y queso',
                'description' => 'Crujientes buñuelos hechos con patatas ralladas mezcladas con queso y cebolla, fritos en la sartén hasta que se doran, para un delicioso aperitivo o tentempié.',
                'ingredients' => json_encode(['potato', 'cheese', 'onion']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('recipes')->upsert(
            $recipes,
            ['name'],
            ['description', 'ingredients', 'created_at', 'updated_at'],
        );
    }
}
