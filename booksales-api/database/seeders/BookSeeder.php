<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // 3 data lama
        Book::create([
            'title' => 'Pulang',
            'description' => 'Petualangan seorang pemuda yang kembali ke desa kelahirannya.',
            'price' => 40000.00,
            'stock' => 15,
            'cover_photo' => 'pulang.jpg',
            'genre_id' => 1,
            'author_id' => 1,
        ]);

        Book::create([
            'title' => 'Sebuah Seni untuk Bersikap Bodo Amat',
            'description' => 'Buku yang membahas tentang kehidupan dan folosofi hidup seseorang.',
            'price' => 25000.00,
            'stock' => 5,
            'cover_photo' => 'sebuah_seni.jpg',
            'genre_id' => 2,
            'author_id' => 2,
        ]);

        Book::create([
            'title' => 'Naruto',
            'description' => 'Buku yang membahas tentang jalan ninja seseorang.',
            'price' => 30000.00,
            'stock' => 55,
            'cover_photo' => 'naruto.jpg',
            'genre_id' => 3,
            'author_id' => 3,
        ]);

        // 5 data dummy baru (Total 8 data)
        Book::create([
            'title' => 'Laskar Pelangi',
            'description' => 'Kisah perjuangan 10 anak di Belitung.',
            'price' => 45000.00,
            'stock' => 20,
            'cover_photo' => 'laskar.jpg',
            'genre_id' => 2,
            'author_id' => 1,
        ]);

        Book::create([
            'title' => 'Bumi',
            'description' => 'Petualangan fantasi di dunia pararel.',
            'price' => 50000.00,
            'stock' => 30,
            'cover_photo' => 'bumi.jpg',
            'genre_id' => 3,
            'author_id' => 2,
        ]);

        Book::create([
            'title' => 'Harry Potter and the Sorcerer\'s Stone',
            'description' => 'Kisah seorang anak ajaib di sekolah sihir Hogwarts.',
            'price' => 120000.00,
            'stock' => 10,
            'cover_photo' => 'hp.jpg',
            'genre_id' => 3,
            'author_id' => 3,
        ]);

        Book::create([
            'title' => 'The Thief and the Dogs',
            'description' => 'Novel klasik Mesir tentang pengkhianatan dan keadilan.',
            'price' => 65000.00,
            'stock' => 5,
            'cover_photo' => 'thief.jpg',
            'genre_id' => 1,
            'author_id' => 4,
        ]);

        Book::create([
            'title' => 'Air Power in the 21st Century',
            'description' => 'Analisis tentang peran teknologi dalam perang modern.',
            'price' => 90000.00,
            'stock' => 8,
            'cover_photo' => 'airpower.jpg',
            'genre_id' => 1,
            'author_id' => 5,
        ]);
    }
}
