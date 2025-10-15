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
            'country' => 'Indonesia',
        ]);

        Author::create([
            'name' => 'Tere Liye',
            'country' => 'Indonesia',
        ]);

        Author::create([
            'name' => 'J.K. Rowling',
            'country' => 'United Kingdom',
        ]);

        Author::create([
            'name' => 'Naguib Mahfouz',
            'country' => 'Mesir',
        ]);

        Author::create([
            'name' => 'Benedict Evans',
            'country' => 'United Kingdom',
        ]);
    }
}
