<?php

namespace App\Models;

class Book
{
    public int $id;
    public string $Title;
    public string $author;
    public string $ISBN;
    public string $Genre;
    public string $Description;
    public int $published_year;
    public string $cover_url;
    public ?string $created_at;

    public static function fromArray(array $row): Book
    {
        $b = new Book();

        $b->id = (int)($row['id'] ?? 0);
        $b->Title = (string)($row['Title'] ?? '');
        $b->author = (string)($row['author'] ?? '');
        $b->ISBN = (string)($row['ISBN'] ?? '');
        $b->Genre = (string)($row['Genre'] ?? '');
        $b->Description = (string)($row['Description'] ?? '');
        $b->published_year = (int)($row['published_year'] ?? 0);
        $b->cover_url = (string)($row['cover_url'] ?? '');
        $b->created_at = $row['created_at'] ?? null;

        return $b;
    }
}
