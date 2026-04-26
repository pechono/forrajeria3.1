<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create(['categoria'=>'Alimento Perro']);
        Categoria::create(['categoria'=>'Alimento Gato']);
        Categoria::create(['categoria'=>'Pañales']);
       
        Categoria::create(['categoria'=>'Oferta']);


    }
}
