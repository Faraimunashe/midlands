<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = [
            ['name' => 'Mr'],
            ['name' => 'Mrs'],
            ['name' => 'Miss'],
            ['name' => 'Ms'],
            ['name' => 'Dr'],
            ['name' => 'Prof'],
            ['name' => 'Rev'],
            ['name' => 'Sir'],
            ['name' => 'Dame'],
            ['name' => 'Capt'],
            ['name' => 'Col'],
            ['name' => 'Maj'],
            ['name' => 'Gen'],
            ['name' => 'Lt'],
            ['name' => 'Fr'],
            ['name' => 'Sr'],
            ['name' => 'Br'],
            ['name' => 'Lord'],
            ['name' => 'Lady'],
            ['name' => 'Baron'],
            ['name' => 'Baroness'],
            ['name' => 'Rabbi'],
            ['name' => 'Imam'],
            ['name' => 'Engr'],
            ['name' => 'Arch.'],
            ['name' => 'Er.'],
            ['name' => 'Adv.'],
            ['name' => 'Cllr'],
        ];

        DB::table('titles')->insert($titles);
    }
}
