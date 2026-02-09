<?php

namespace App\Repository;

use App\Framework\BaseRepository;

class BookRepository extends BaseRepository implements IBookRepository
{
    public function getAll(string $search = ''): array
    {
        if ($search === '') {
            return $this->fetchAll(
                "SELECT * FROM books ORDER BY Title"
            );
        }

        $like = '%' . $search . '%';

        return $this->fetchAll(
            "SELECT * FROM books
             WHERE Title LIKE ? OR author LIKE ?
             ORDER BY Title",
            [$like, $like]
        );
    }

    public function findById(int $id): ?array
    {
        return $this->fetchOne(
            "SELECT * FROM books WHERE id = ?",
            [$id]
        );
    }

    public function countAll(): int
    {
        $row = $this->fetchOne("SELECT COUNT(*) as cnt FROM books");
        return (int)($row['cnt'] ?? 0);
    }

    public function countGenres(): int
    {
        $row = $this->fetchOne("SELECT COUNT(DISTINCT Genre) as cnt FROM books");
        return (int)($row['cnt'] ?? 0);
    }
}
