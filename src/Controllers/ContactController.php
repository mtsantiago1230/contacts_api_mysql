<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\ContactService;
use App\Helpers\Response;
use InvalidArgumentException;

class ContactController
{
    public function __construct(
        private ContactService $service
    ) {}

    /**
     * GET /contacts
     */
    public function index(): void
    {
        $contacts = $this->service->list();
        Response::json(['data' => $contacts]);
    }

    /**
     * POST /contacts
     */
    public function store(): void
    {
        // Obtener datos JSON del cuerpo de la solicitud
        $input = json_decode(file_get_contents('php://input'), true);

        // Validar que el cuerpo sea un array
        if ($input === null || !is_array($input)) {
            Response::error('Cuerpo inválido. Se esperaba JSON.', 400);
        }

        try {
            // Crear un nuevo contacto
            $id = $this->service->create($input);
            Response::json(
                ['message' => 'Contacto creado', 'id' => $id],
                201
            );
        } catch (InvalidArgumentException $e) {
            Response::error($e->getMessage(), 400);
        }
    }

    /**
     * DELETE /contacts/{id}
     */
    public function delete(int $id): void
    {
        try {
            // Validar y eliminar el contacto
            $deleted = $this->service->delete($id);

            if ($deleted) {
                Response::json(['message' => 'Contacto eliminado']);
            } else {
                Response::error('Contacto no encontrado', 404);
            }
        } catch (InvalidArgumentException $e) {
            Response::error($e->getMessage(), 400);
        }
    }
}
