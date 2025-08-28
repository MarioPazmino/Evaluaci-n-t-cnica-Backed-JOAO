<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;

class ClienteService
{
    /**
     * Obtener todos los clientes
     */
    public function getAllClientes(): Collection
    {
        return Cliente::all();
    }

    /**
     * Crear un nuevo cliente
     */
    public function createCliente(array $data): Cliente
    {
        return Cliente::create($data);
    }

    /**
     * Eliminar un cliente
     */
    public function deleteCliente(Cliente $cliente): bool
    {
        return $cliente->delete();
    }

    /**
     * Buscar cliente por email
     */
    public function findByEmail(string $email): ?Cliente
    {
        return Cliente::where('email', $email)->first();
    }
}
