<?php

use Illuminate\Database\Seeder;
use App\Model\StatusMahasiswa;

class StatusMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','nama_status' => 'Aktif','keterangan' => 'Aktif kuliah','id_periode' => 1,'is_archived' => 0],
            ['id' => '2','nama_status' => 'Non aktif','keterangan' => 'Tidak aktif kuliah / tanpa keterangan','id_periode' => 1,'is_archived' => 0],
            ['id' => '3','nama_status' => 'Cuti','keterangan' => 'Cuti kuliah','id_periode' => 1,'is_archived' => 0],
            ['id' => '4','nama_status' => 'Lulus','keterangan' => 'Tamat kuliah','id_periode' => 1,'is_archived' => 0],
            ['id' => '5','nama_status' => 'Mengundurkan diri','keterangan' => 'Berhenti kuliah','id_periode' => 1,'is_archived' => 0],
       ];
       StatusMahasiswa::insert($records);
    }
}
