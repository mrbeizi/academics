<?php

use Illuminate\Database\Seeder;
use App\Model\Perkuliahan\StatusKelasKuliah;

class StatusKelasKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['nama_status' => 'Reguler','keterangan' => 'Kuliah Normal','id_periode' => 1,'is_archived' => 0],
            ['nama_status' => 'Pindah Kelas','keterangan' => 'Untuk mahasiswa yang pindah dari prodi lain','id_periode' => 1,'is_archived' => 0],
            ['nama_status' => 'Konversi','keterangan' => 'Untuk matakuliah yang dikonversi dari perkuliahan luar','id_periode' => 1,'is_archived' => 0],
            ['nama_status' => 'Virtual','keterangan' => 'Kelas yang tidak dihitung oleh uvers','id_periode' => 1,'is_archived' => 0],
       ];
       StatusKelasKuliah::insert($records);
    }
}
