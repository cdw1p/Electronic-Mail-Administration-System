<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
            'zoom_key'      => '8DSjlj9eRai2gnVtc0zb2g',
            'zoom_secret'   => 'E34aAAhaL7difZI1et8LID7QNpG0ldlsP1vy',
            'smtp_host'     => 'smtp.gmail.com',
            'smtp_port'     => '587',
            'smtp_username' => '',
            'smtp_password' => ''
        ]);
    }
}
