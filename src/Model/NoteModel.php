<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\StorageException;
use App\Exception\NotFoundException;
use PDO;
use Throwable;

class NoteModel extends AbstractModel implements ModelInterface
{
    public function create(array $data): void
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

    public function search
    (
        int $pageNumber, 
        int $pageSize, 
        string $orderBy, 
        string $sortOrder, 
        string $phrase
    ): array {
        return $this->findBy($pageNumber, $pageSize, $orderBy, $sortOrder, $phrase);
    }

    public function list
    (
        int $pageNumber, 
        int $pageSize, 
        string $orderBy, 
        string $sortOrder
    ): array {
        return $this->findBy($pageNumber, $pageSize, $orderBy, $sortOrder, null);
    }

    public function count(): int
    {
        try {
            $sql = "SELECT COUNT(*) AS c FROM notes";
            $query = $this->conn->query($sql, PDO::FETCH_ASSOC);
            $result = $query->fetch();
            if (!$result) {
                throw new StorageException('Błąd pobrania ilości notatek', 400);
            }
            return $result['c'];
        } catch (Throwable $e) {
            throw new StorageException('Błąd pobrania ilości notatek', 400, $e);
        } 
    }

    public function searchCount(string $phrase): int
    {
        try {
            $phrase = $this->conn->quote('%' . $phrase . '%', PDO::PARAM_STR);
            $sql = "SELECT COUNT(*) AS c FROM notes WHERE title LIKE " . $phrase;
            $query = $this->conn->query($sql, PDO::FETCH_ASSOC);
            $result = $query->fetch();
            if (!$result) {
                throw new StorageException('Błąd pobrania ilości notatek', 400);
            }
            return $result['c'];
        } catch (Throwable $e) {
            throw new StorageException('Błąd pobrania ilości notatek', 400, $e);
        }
    }

    public function get(int $id): array
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

    public function edit(int $id, array $data): void
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $sql = "UPDATE notes SET title=" . $title . ", description=" . $description . " WHERE id=" . $id;
            $this->conn->exec($sql);
        } catch (Throwable $e) {
            throw new StorageException('Błąd aktualizacji notatki', 400, $e);
        }
    }

    public function delete(int $id): void
    {
        try {
            $sql = "DELETE FROM notes WHERE id = " . $id . " LIMIT 1";
            $this->conn->exec($sql);
        } catch (Throwable $e) {
            throw new StorageException('Błąd usunięcia notatki', 400, $e);
        }
    }

    private function findBy(int $pageNumber, int $pageSize, string $orderBy, string $sortOrder, ?string $phrase): array
    {
        $limit = $pageSize;
        $offset = $pageSize * ($pageNumber - 1);
        try {
            if (!in_array($orderBy, ['title', 'created'])) {
                $orderBy = 'title';
            }
            if (!in_array($sortOrder, ['asc', 'desc'])) {
                $sortOrder = 'desc';
            }
            if ($phrase) {
                $phrase = $this->conn->quote('%' . $phrase . '%', PDO::PARAM_STR);
                $sql = "SELECT id, title, created FROM notes WHERE title LIKE (" . $phrase . ") ORDER BY " . $orderBy . " " . $sortOrder . " LIMIT " . $offset . ", " . $limit;
            } else {
                $sql = "SELECT id, title, created FROM notes ORDER BY " . $orderBy . " " . $sortOrder . " LIMIT " . $offset . ", " . $limit;
            }
            $result = $this->conn->query($sql, PDO::FETCH_ASSOC);
            return $result->fetchAll();        
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać notatek', 400);
        }
    }
}