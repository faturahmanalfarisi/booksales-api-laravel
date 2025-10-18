<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::create([
            'name' => 'Andrea Hirata',
            'photo' => 'andrea_hirata.jpg',
            'bio' => 'Penulis Laskar Pelangi dari Belitung.',
        ]);

        Author::create([
            'name' => 'Tere Liye',
            'photo' => 'tere_liye.jpg',
            'bio' => 'Penulis fiksi populer Indonesia dengan genre fantasi dan romansa.',
        ]);

        Author::create([
            'name' => 'J.K. Rowling',
            'photo' => 'jk_rowling.jpg',
            'bio' => 'Penulis asal Inggris, terkenal dengan seri Harry Potter.',
        ]);

        Author::create([
            'name' => 'Naguib Mahfouz',
            'photo' => null,
            'bio' => 'Pemenang Nobel Sastra asal Mesir.',
        ]);

        Author::create([
            'name' => 'Benedict Evans',
            'photo' => null,
            'bio' => 'Analis teknologi dan strategi pasar.',
        ]);
    }
}
