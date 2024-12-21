<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['work', 'home', 'sport', 'fun', 'other'];
        foreach ($names as $name) {
            Tag::create(['name' => $name]);
        }
    }
}
