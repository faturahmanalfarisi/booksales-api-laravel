<?php

namespace App\Models;

class Author
{
    private static $authors = [
        [
            'id' => 1,
            'name' => 'Andrea Hirata',
            'country' => 'Indonesia'
        ],
        [
            'id' => 2,
            'name' => 'Tere Liye',
            'country' => 'Indonesia'
        ],
        [
            'id' => 3,
            'name' => 'J.K. Rowling',
            'country' => 'United Kingdom'
        ],
        [
            'id' => 4,
            'name' => 'Naguib Mahfouz',
            'country' => 'Mesir'
        ],
        [
            'id' => 5,
            'name' => 'Benedict Evans',
            'country' => 'United Kingdom'
        ],
    ];

    public static function all()
    {
        return self::$authors;
    }
}
