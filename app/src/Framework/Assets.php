<?php
namespace App\Framework;

final class Assets
{
    public static function coverSrc(?string $u): string
    {
        $default = '/assets/Uploads/covers/default-cover.svg';
        $u = trim((string)($u ?? ''));
        if ($u === '') return $default;
        if (filter_var($u, FILTER_VALIDATE_URL)) return $u;
        // handle legacy phpMyAdmin /images/ paths
        if (str_starts_with($u, '/images/')) {
            $name = basename($u);
            if ($name === 'default-cover.png') return $default;
            return '/assets/Uploads/covers/' . $name;
        }
        if (str_starts_with($u, '/')) return $u;
        if (str_contains($u, 'assets/')) return '/' . ltrim($u, '/');
        return '/assets/Uploads/covers/' . ltrim($u, '/');
    }
}
