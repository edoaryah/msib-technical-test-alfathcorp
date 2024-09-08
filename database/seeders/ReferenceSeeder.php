<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Reference;

class ReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reference::insert([
            ['code' => 'overtime_method1', 'name' => 'Tipe 1', 'expression' => '10000 * overtime_duration_total'],
            ['code' => 'overtime_method2', 'name' => 'Tipe 2', 'expression' => '20000 * overtime_duration_total'],
        ]);
    }
}
