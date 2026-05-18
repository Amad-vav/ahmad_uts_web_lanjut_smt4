<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MosqueSeeder extends Seeder
{
    public function run()
    {
        $items = [
            [
                'name' => "Masjid Al-Ikhlas",
                'address' => "Jl. Kebajikan No.1, Jakarta",
                'lat' => -6.200692,
                'lng' => 106.816583,
                'description' => 'Masjid aktif mengadakan program Jumat Berkah: pembagian makanan dan paket sembako setiap Jumat setelah sholat.',
                'contact' => '+62 21 555 0101',
            ],
            [
                'name' => 'Masjid Ar-Rahman',
                'address' => 'Komplek Amal, Depok',
                'lat' => -6.402484,
                'lng' => 106.794029,
                'description' => 'Komunitas kecil namun kompak, terbuka untuk donasi makanan dan dana.',
                'contact' => '+62 21 555 0202',
            ],
            [
                'name' => 'Masjid Nurul Huda',
                'address' => 'Bekasi Kota',
                'lat' => -6.235,
                'lng' => 106.992,
                'description' => 'Menerima donasi makanan, fokus pada pendistribusian ke panti asuhan dan tukang becak.',
                'contact' => '+62 21 555 0303',
            ],
        ];

        foreach($items as $i){
            DB::table('mosques')->insert(array_merge($i, ['created_at'=>now(),'updated_at'=>now()]));
        }
    }
}
