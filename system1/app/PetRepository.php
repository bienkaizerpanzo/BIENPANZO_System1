<?php

class PetRepository
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function findAll(): array
    {
        try {
            $pdo = $this->database->getConnection();
            $stmt = $pdo->query('SELECT * FROM pets ORDER BY id DESC');

            return $stmt->fetchAll();
        } catch (Throwable $e) {
            throw new RuntimeException('Unable to load pets right now. Please try again later.');
        }
    }

    public function findById(int $id): ?array
    {
        try {
            $pdo = $this->database->getConnection();
            $stmt = $pdo->prepare('SELECT * FROM pets WHERE id = :id LIMIT 1');
            $stmt->execute([':id' => $id]);

            $pet = $stmt->fetch();

            return $pet ?: null;
        } catch (Throwable $e) {
            throw new RuntimeException('Unable to load this pet right now. Please try again later.');
        }
    }

    public function create(array $data): bool
    {
        try {
            $pdo = $this->database->getConnection();
            $stmt = $pdo->prepare('
                INSERT INTO pets (pet_name, pet_type_id, pet_type, breed, age, gender, owner_name, contact_number, status)
                VALUES (:pet_name, :pet_type_id, :pet_type, :breed, :age, :gender, :owner_name, :contact_number, :status)
            ');

            return $stmt->execute([
                ':pet_name' => $data['pet_name'],
                ':pet_type_id' => isset($data['pet_type_id']) ? (int) $data['pet_type_id'] : null,
                ':pet_type' => $data['pet_type'],
                ':breed' => $data['breed'],
                ':age' => (int) $data['age'],
                ':gender' => $data['gender'],
                ':owner_name' => $data['owner_name'],
                ':contact_number' => $data['contact_number'],
                ':status' => $data['status'],
            ]);
        } catch (Throwable $e) {
            throw new RuntimeException('Unable to create this pet right now. Please try again later.');
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $pdo = $this->database->getConnection();
            $stmt = $pdo->prepare('
                UPDATE pets
                SET pet_name = :pet_name,
                    pet_type_id = :pet_type_id,
                    pet_type = :pet_type,
                    breed = :breed,
                    age = :age,
                    gender = :gender,
                    owner_name = :owner_name,
                    contact_number = :contact_number,
                    status = :status
                WHERE id = :id
            ');

            return $stmt->execute([
                ':pet_name' => $data['pet_name'],
                ':pet_type_id' => isset($data['pet_type_id']) ? (int) $data['pet_type_id'] : null,
                ':pet_type' => $data['pet_type'],
                ':breed' => $data['breed'],
                ':age' => (int) $data['age'],
                ':gender' => $data['gender'],
                ':owner_name' => $data['owner_name'],
                ':contact_number' => $data['contact_number'],
                ':status' => $data['status'],
                ':id' => $id,
            ]);
        } catch (Throwable $e) {
            throw new RuntimeException('Unable to update this pet right now. Please try again later.');
        }
    }

    public function delete(int $id): bool
    {
        try {
            $pdo = $this->database->getConnection();
            $stmt = $pdo->prepare('DELETE FROM pets WHERE id = :id');

            return $stmt->execute([':id' => $id]);
        } catch (Throwable $e) {
            throw new RuntimeException('Unable to delete this pet right now. Please try again later.');
        }
    }
}
