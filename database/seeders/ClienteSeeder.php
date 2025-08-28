<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = [
            [
                'nombre' => 'Juan Pérez',
                'email' => 'juan.perez@example.com',
                'telefono' => '+1234567890'
            ],
            [
                'nombre' => 'María García',
                'email' => 'maria.garcia@example.com',
                'telefono' => '+0987654321'
            ],
            [
                'nombre' => 'Carlos López',
                'email' => 'carlos.lopez@example.com',
                'telefono' => null
            ],
            [
                'nombre' => 'Ana Martínez',
                'email' => 'ana.martinez@example.com',
                'telefono' => '+1122334455'
            ],
            [
                'nombre' => 'Luis Rodríguez',
                'email' => 'luis.rodriguez@example.com',
                'telefono' => '+5566778899'
            ]
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
