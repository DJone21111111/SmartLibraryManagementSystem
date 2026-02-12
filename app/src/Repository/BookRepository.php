<?php

namespace App\Repository;

use App\Framework\BaseRepository;

class BookRepository extends BaseRepository implements IBookRepository
{
    public function getAll(string $search = '', string $filter = ''): array
    {
        $params = [];
        $where = [];

        if ($search !== '') {
            $where[] = "(b.Title LIKE ? OR b.author LIKE ? )";
            $like = '%' . $search . '%';
            $params[] = $like;
            $params[] = $like;
        }

        $filter = strtolower(trim($filter));
        if ($filter === 'available') {
            // available = total_copies - active_loans - active_reservations
            $where[] = "(
                (SELECT COUNT(*) FROM book_copies bc WHERE bc.book_id = b.id)
                - COALESCE((SELECT COUNT(*) FROM loans l JOIN book_copies bc2 ON bc2.id = l.copy_id WHERE bc2.book_id = b.id AND l.returned_at IS NULL), 0)
                - COALESCE((SELECT COUNT(*) FROM reservations r WHERE r.book_id = b.id AND r.Status IN ('waiting','ready')), 0)
            ) > 0";
        } elseif ($filter === 'overdue') {
            // show books that currently have at least one overdue loan
            $where[] = "EXISTS (SELECT 1 FROM loans l JOIN book_copies bc ON bc.id = l.copy_id WHERE bc.book_id = b.id AND l.returned_at IS NULL AND l.due_at < NOW())";
        } elseif ($filter === 'reserved') {
            $where[] = "EXISTS (SELECT 1 FROM reservations r WHERE r.book_id = b.id AND r.Status IN ('waiting','ready'))";
        }

                $sql = "SELECT b.*,
                                     (SELECT COUNT(*) FROM book_copies bc WHERE bc.book_id = b.id)
                                         - COALESCE((SELECT COUNT(*) FROM loans l JOIN book_copies bc2 ON bc2.id = l.copy_id WHERE bc2.book_id = b.id AND l.returned_at IS NULL), 0)
                                         - COALESCE((SELECT COUNT(*) FROM reservations r WHERE r.book_id = b.id AND r.Status IN ('waiting','ready')), 0)
                                     AS available,
                                     (SELECT COUNT(*) FROM book_copies bc WHERE bc.book_id = b.id) AS total_copies
                                FROM books b";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $sql .= " ORDER BY b.Title";

        return $this->fetchAll($sql, $params);
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

    public function countAvailable(): int
    {
        $row = $this->fetchOne(
            "SELECT COUNT(*) as cnt FROM books b
             WHERE (
                (SELECT COUNT(*) FROM book_copies bc WHERE bc.book_id = b.id)
                - COALESCE((SELECT COUNT(*) FROM loans l JOIN book_copies bc2 ON bc2.id = l.copy_id WHERE bc2.book_id = b.id AND l.returned_at IS NULL), 0)
                - COALESCE((SELECT COUNT(*) FROM reservations r WHERE r.book_id = b.id AND r.Status IN ('waiting','ready')), 0)
             ) > 0"
        );

        return (int)($row['cnt'] ?? 0);
    }
}
