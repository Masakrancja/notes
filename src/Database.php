<?php

declare(strict_types=1);

namespace App;

use App\Exception\StorageException;
use App\Exception\NotFoundException;
use PDO;
use PDOException;
use Throwable;

class Database
{
    private PDO $conn;

    public function __construct($config)
    {
        try {
            $this->validateConfig($config);
            $this->createConnection($config);
        } catch(PDOException $e) {
            throw new StorageException('Błąd połączenia z bazą danych');
        }
    }

    private function validateConfig(array $config): void
    {
        if (empty($config['database']) || empty($config['host']) || empty($config['user']) || empty($config['password'])) {
            throw new StorageException('Configuration Error');
        }
    }

    private function createConnection(array $config): void
    {
        $dns = 'mysql:dbname=' . $config['database'] . ';host=' . $config['host'];
        $this->conn = new PDO(
            $dns,
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public function createNote(array $data): void
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $created = $this->conn->quote(date("Y-m-d H:i:s"));
            $sql = "INSERT INTO notes (title, description, created) VALUES ($title, $description, $created)";
            $this->conn->exec($sql);
        } catch (Throwable $e) {
            throw new StorageException('Błąd utworzenia notatki', 400, $e);
        }
    }

    public function getNotes(): array
    {
        try {
            $sql = "SELECT id, title, created FROM notes";
            $result = $this->conn->query($sql, PDO::FETCH_ASSOC);
            return $result->fetchAll();        
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać notatek', 400);
        }
    }


    public function getNote(int $id): array
    {
        try {
            $sql = "SELECT * FROM notes WHERE id = " . $id;
            $query = $this->conn->query($sql, PDO::FETCH_ASSOC);
            $note = $query->fetch();
        } catch (Throwable $e) {
            throw new StorageException('Błąd pobrania notatki', 400, $e);
        }
        if (!$note) {
            throw new NotFoundException('Notatka o id: ' . $id . ' nie została znaleziona', 400);
        }
        return $note;
    }

}