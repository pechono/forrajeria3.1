<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::create([

            'empresa'=>'Forrajeria Lolita',
            'direccion'=>'Majul Ayan 278',
            'telefono'=>' 3826 54-0417',
            'mail'=>'-'
        ]);
    }
}
