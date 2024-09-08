<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insert([
            ['key' => 'overtime_method', 'value' => '1'],
        ]);
    }
}
