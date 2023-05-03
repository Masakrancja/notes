<?php

declare(strict_types=1);

namespace App\Model;

interface ModelInterface
{
    public function create(array $data): void;

    public function search
    (
        int $pageNumber, 
        int $pageSize, 
        string $orderBy, 
        string $sortOrder, 
        string $phrase
    ): array;

    public function list
    (
        int $pageNumber, 
        int $pageSize, 
        string $orderBy, 
        string $sortOrder
    ): array;

    public function count(): int;

    public function searchCount(string $phrase): int;

    public function get(int $id): array;

    public function edit(int $id, array $data): void;

    public function delete(int $id): void;

}