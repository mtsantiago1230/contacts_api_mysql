<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

class ContactRepository
{
    public function __construct(
        private PDO $pdo
    ) {}

    // Crea un nuevo contacto y devuelve su ID
    public function createContact(string $firstName, string $lastName, string $email): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO contacts (first_name, last_name, email) VALUES (?, ?, ?)'
        );
        $stmt->execute([$firstName, $lastName, $email]);

        return (int)$this->pdo->lastInsertId();
    }

    // Agrega un teléfono a un contacto
    public function addPhone(int $contactId, string $phone): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO phones (contact_id, phone) VALUES (?, ?)'
        );
        $stmt->execute([$contactId, $phone]);
    }

    // Obtiene todos los contactos con sus teléfonos
    public function getAllContacts(): array
    {
        $stmt = $this->pdo->query(
            'SELECT c.id, c.first_name, c.last_name, c.email, c.created_at,
                    p.id AS phone_id, p.phone
             FROM contacts c
             LEFT JOIN phones p ON p.contact_id = c.id
             ORDER BY c.id DESC'
        );

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $contacts = [];

        // recorremos los resultados y los organizamos
        foreach ($rows as $row) {
            $id = (int)$row['id'];

            if (!isset($contacts[$id])) {
                $contacts[$id] = [
                    'id'         => $id,
                    'first_name' => $row['first_name'],
                    'last_name'  => $row['last_name'],
                    'email'      => $row['email'],
                    'created_at' => $row['created_at'],
                    'phones'     => [],
                ];
            }

            // Si hay un teléfono, lo agregamos al contacto
            if (!empty($row['phone'])) {
                $contacts[$id]['phones'][] = [
                    'id'    => (int)$row['phone_id'],
                    'phone' => $row['phone'],
                ];
            }
        }

        return array_values($contacts);
    }

    // Elimina un contacto por ID
    public function deleteContact(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM contacts WHERE id = ?'
        );
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    // Verifica si un email ya existe
    public function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT id FROM contacts WHERE email = ? LIMIT 1'
        );
        $stmt->execute([$email]);

        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }
}
