<?php

use Illuminate\Database\Seeder;
use App\Model\GolMatakuliah;

class GolMatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $records = [
            ['nama_golongan' => 'MKU','keterangan' => 'Matakuliah Umum, Semua Fakultas','id_fakultas'=>NULL,'id_prodi'=>NULL],
            ['nama_golongan' => 'Fakultas - Bisnis','keterangan' => '','id_fakultas'=>1,'id_prodi'=>NULL],
            ['nama_golongan' => 'Fakultas - Komputer','keterangan' => '','id_fakultas'=>2,'id_prodi'=>NULL],
            ['nama_golongan' => 'Fakultas - Seni','keterangan' => '','id_fakultas'=>3,'id_prodi'=>NULL],
            ['nama_golongan' => 'Fakultas - Teknik','keterangan' => '','id_fakultas'=>4,'id_prodi'=>NULL],
            ['nama_golongan' => 'Fakultas - Pendidikan, Bahasa, dan Budaya','keterangan' => '','id_fakultas'=>5,'id_prodi'=>NULL],
            ['nama_golongan' => 'Prodi - AK','keterangan' => '','id_fakultas'=>NULL,'id_prodi'=>4],
            ['nama_golongan' => 'Prodi - MN','keterangan' => '','id_fakultas'=>NULL,'id_prodi'=>3],
            ['nama_golongan' => 'Prodi - PBM','keterangan' => '','id_fakultas'=>NULL,'id_prodi'=>10],
            ['nama_golongan' => 'Prodi - SI','keterangan' => '','id_fakultas'=>NULL,'id_prodi'=>6],
            ['nama_golongan' => 'Prodi - SM','keterangan' => '','id_fakultas'=>NULL,'id_prodi'=>2],
            ['nama_golongan' => 'Prodi - ST','keterangan' => '','id_fakultas'=>NULL,'id_prodi'=>1],
            ['nama_golongan' => 'Prodi - TI','keterangan' => '','id_fakultas'=>NULL,'id_prodi'=>8],
            ['nama_golongan' => 'Prodi - TIF','keterangan' => '','id_fakultas'=>NULL,'id_prodi'=>5],
            ['nama_golongan' => 'Prodi - TL','keterangan' => '','id_fakultas'=>NULL,'id_prodi'=>9],
            ['nama_golongan' => 'Prodi - TPL','keterangan' => '','id_fakultas'=>NULL,'id_prodi'=>7]
       ];
       GolMatakuliah::insert($records);
    }
}
