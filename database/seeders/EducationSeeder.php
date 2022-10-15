<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institution_names = [
            "Universitas Indonesia",
            "Universitas Gadjah Mada",
            "Universitas Brawijaya",
            "Institut Teknologi Bandung",
            "Universitas Airlangga",
            "Universitas Bina Nusantara",
            "Universitas Padjadjaran",
            "Universitas Sebelas Maret",
            "Universitas Diponegoro",
            "Institut Pertanian Bogor",
            "Universitas Telkom",
            "Institut Teknologi Sepuluh Nopember",
            "Universitas Pendidikan Indonesia",
            "Universitas Negeri Semarang",
            "Universitas Teknokrat Indonesia",
            "Universitas Negeri Yogyakarta",
            "Universitas Gunadarma",
            "Universitas Jenderal Soedirman",
            "Universitas Jember",
            "Universitas Negeri Malang",
        ];

        foreach ($institution_names as $institution) {
            $exists = DB::table('educations')
                ->where('name', $institution)
                ->first();

            if (empty($exists)) {
                DB::table('educations')->insert([
                    'name' => $institution,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
