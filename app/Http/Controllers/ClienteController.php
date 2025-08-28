<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Resources\ClienteResource;
use App\Services\ClienteService;
use Illuminate\Http\JsonResponse;

class ClienteController extends Controller
{
    protected ClienteService $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $search = request('search');
            $perPage = request('per_page', 10);

            if ($search || request('paginate', false)) {
                $clientes = $this->clienteService->searchClientes($search, $perPage);
                return response()->json([
                    'success' => true,
                    'data' => ClienteResource::collection($clientes->items()),
                    'pagination' => [
                        'current_page' => $clientes->currentPage(),
                        'last_page' => $clientes->lastPage(),
                        'per_page' => $clientes->perPage(),
                        'total' => $clientes->total(),
                        'from' => $clientes->firstItem(),
                        'to' => $clientes->lastItem(),
                    ]
                ], 200);
            }

            $clientes = $this->clienteService->getAllClientes();
            return response()->json([
                'success' => true,
                'data' => ClienteResource::collection($clientes)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los clientes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request): JsonResponse
    {
        try {
            $cliente = $this->clienteService->createCliente($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Cliente creado exitosamente',
                'data' => new ClienteResource($cliente)
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente): JsonResponse
    {
        try {
            $this->clienteService->deleteCliente($cliente);
            
            return response()->json([
                'success' => true,
                'message' => 'Cliente eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente): JsonResponse
    {
        try {
            $clienteActualizado = $this->clienteService->updateCliente($cliente, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Cliente actualizado exitosamente',
                'data' => new ClienteResource($clienteActualizado)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if email already exists
     */
    public function checkEmail(string $email): JsonResponse
    {
        try {
            $clienteId = request('exclude_id'); // Para excluir el ID actual en edición
            $cliente = $this->clienteService->findByEmail($email);
            
            $exists = $cliente && (!$clienteId || $cliente->id != $clienteId);
            
            return response()->json([
                'success' => true,
                'exists' => $exists
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar el email',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
