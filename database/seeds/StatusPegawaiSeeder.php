<?php

use Illuminate\Database\Seeder;
use App\Model\StatusPegawai;

class StatusPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','nama_status' => 'Aktif','keterangan' => 'Aktif bekerja di Uvers','id_periode' => 1],
            ['id' => '2','nama_status' => 'Cuti','keterangan' => '-','id_periode' => 1],
            ['id' => '3','nama_status' => 'Mengundurkan Diri','keterangan' => 'Tidak bekerja lagi','id_periode' => 1],
       ];
       StatusPegawai::insert($records);
    }
}
