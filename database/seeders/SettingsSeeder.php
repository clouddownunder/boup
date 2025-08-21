<?php

namespace Database\Seeders;
use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::truncate();
        Settings::insert([[
            'setting_key' => 'iOS_version_code',
            'setting_label' => 'iOS Version',
            'setting_value' => '1.0.0',
        ],[
            'setting_key' => 'android_version_code',
            'setting_label' => 'Android Version',
            'setting_value' => '1.0.0',
        ],[
            'setting_key' => 'show_device_info',
            'setting_label' => 'Show Device Info',
            'setting_value' => 1,
        ]]);
    }
}
