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
     * Actualizar un cliente
     */
    public function updateCliente(Cliente $cliente, array $data): Cliente
    {
        $cliente->update($data);
        return $cliente->fresh();
    }

    /**
     * Buscar cliente por email
     */
    public function findByEmail(string $email): ?Cliente
    {
        return Cliente::where('email', $email)->first();
    }

    /**
     * Buscar clientes con filtros
     */
    public function searchClientes(string $search = null, int $perPage = 10)
    {
        $query = Cliente::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('telefono', 'LIKE', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }
}
