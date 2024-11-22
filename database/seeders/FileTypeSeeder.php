<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fileTypes = [
            ['name' => 'PDF'],
            ['name' => 'Word'],
            ['name' => 'Excel'],
            ['name' => 'PowerPoint'],
            ['name' => 'Image'],
            ['name' => 'Text'],
            ['name' => 'CSV'],
            ['name' => 'ZIP'],
            ['name' => 'Audio'],
            ['name' => 'Video'],
        ];

        DB::table('file_types')->insert($fileTypes);
    }
}
