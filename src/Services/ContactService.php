<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ContactRepository;
use InvalidArgumentException;

class ContactService
{
    public function __construct(
        private ContactRepository $repo
    ) {}

    // Crea un nuevo contacto con validaciones
    public function create(array $data): int
    {
        $first = trim($data['first_name'] ?? '');
        $last  = trim($data['last_name'] ?? '');
        $email = trim($data['email'] ?? '');
        $phones = $data['phones'] ?? [];

        // Validaciones de los datos recibidos
        $this->validateRequiredFields($first, $last, $email);
        $this->validateEmail($email);
        $this->validateUniqueEmail($email);

        // Validar teléfonos
        $phones = is_string($phones) ? [$phones] : (array)$phones;
        $this->validatePhones($phones);

        // Si todo es válido, creamos el contacto y guardamos los teléfonos
        $contactId = $this->repo->createContact($first, $last, $email);
        $this->savePhones($contactId, $phones);

        return $contactId;
    }

    // valida campos obligatorios
    private function validateRequiredFields(string $first, string $last, string $email): void
    {
        if ($first === '' || $last === '' || $email === '') {
            throw new InvalidArgumentException('first_name, last_name y email son obligatorios');
        }
    }

    // valida formato email
    private function validateEmail(string $email): void
    {
        $patternEmail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (!preg_match($patternEmail, $email)) {
            throw new InvalidArgumentException('email inválido');
        }
    }

    // Validar si el email ya existe, ya que debe ser único
    private function validateUniqueEmail(string $email): void
    {
        if ($this->repo->emailExists($email)) {
            throw new InvalidArgumentException('email ya existe');
        }
    }

    // valida teléfonos
    private function validatePhones(array $phones): void
    {
        $patternPhone = '/^[0-9]{7,15}$/';

        foreach ($phones as $phone) {
            $phone = trim($phone);

            // ignorar teléfonos vacíos
            if ($phone === '') {
                continue;
            }

            // Validación simple: solo dígitos y longitud
            if (!preg_match($patternPhone, $phone)) {
                throw new InvalidArgumentException("Teléfono inválido: $phone");
            }
        }
    }

    // guarda teléfonos de un contacto
    private function savePhones(int $contactId, array $phones): void
    {
        foreach ($phones as $phone) {
            $phone = trim($phone);
            if ($phone !== '') {
                $this->repo->addPhone($contactId, $phone);
            }
        }
    }

    // Lista todos los contactos con sus teléfonos
    public function list(): array
    {
        return $this->repo->getAllContacts();
    }

    // Elimina un contacto por ID
    public function delete(int $id): bool
    {
        // Validamos que el ID sea numérico
        if ($id <= 0) {
            throw new InvalidArgumentException('id inválido');
        }
        return $this->repo->deleteContact($id);
    }
}
