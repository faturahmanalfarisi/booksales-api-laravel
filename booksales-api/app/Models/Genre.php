<?php

namespace App\Models;

class Genre
{
    private static $genres = [
        [
            'id' => 1,
            'name' => 'Fiksi',
            'description' => 'Cerita rekaan / imajinatif'
        ],
        [
            'id' => 2,
            'name' => 'Non-Fiksi',
            'description' => 'Berdasarkan fakta / informasi nyata'
        ],
        [
            'id' => 3,
            'name' => 'Fantasi',
            'description' => 'Mengandung unsur magis dan dunia khayalan'
        ],
        [
            'id' => 4,
            'name' => 'Sejarah',
            'description' => 'Berkaitan dengan peristiwa historis'
        ],
        [
            'id' => 5,
            'name' => 'Teknologi',
            'description' => 'Buku tentang komputer dan sains modern'
        ],
    ];

    public static function all()
    {
        return self::$genres;
    }
}
