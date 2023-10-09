<?php

namespace Database\Seeders;

use App\Models\Installation;
use App\Models\Package;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => \Hash::make('admin'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Teknisi',
            'email' => 'teknisi@xmedia.net',
            'password' => \Hash::make('password'),
            'role' => 'teknisi',
        ]);
        Package::create([
            'name' => 'Paket C1',
            'price' => '100000',
            'month' => '1 Bulan',
            'speed' => '3 MBPS',
            'description' => 'Paket hemat dan stabil',
        ]);
        // UserMeta::create([
        //     'phone' => '085213873678',
        //     'address' => 'Bondowoso',
        //     'rt' => '2',
        //     'rw' => '1',
        //     'longlat' => '-',
        //     'province_id' => 35,
        //     'province_name' => 'Jawa Timur',
        //     'regencies_id' => 3511,
        //     'regencies_name' => 'Bondowoso',
        //     'district_id' => '351111',
        //     'district_name' => 'Bondowoso',
        //     'ward_id' => '3511111007',
        //     'ward_name' => 'Dabasah',
        //     'package_id' => 1,
        //     'status' => 'Aktif',
        // ]);
        // User::create([
        //     'name' => 'User',
        //     'email' => 'user@xmedia.net',
        //     'password' => \Hash::make('password'),
        //     'user_meta_id' => 1,
        // ]);
        // Installation::create([
        //     'status' => 'Aktif',
        //     'date_install' => now(),
        //     'end_date' => now(),
        //     'user_id' => 3,
        // ]);
        $this->call(PermissionsSeeder::class);
    }
}
