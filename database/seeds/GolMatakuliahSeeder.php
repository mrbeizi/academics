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
            ['nama_golongan' => 'MKU','keterangan' => 'Matakuliah Umum, Semua Fakultas'],
            ['nama_golongan' => 'Fakultas - Bisnis','keterangan' => ''],
            ['nama_golongan' => 'Fakultas - Komputer','keterangan' => ''],
            ['nama_golongan' => 'Fakultas - Seni','keterangan' => ''],
            ['nama_golongan' => 'Fakultas - Teknik','keterangan' => ''],
            ['nama_golongan' => 'Fakultas - Pendidikan, Bahasa, dan Budaya','keterangan' => ''],
            ['nama_golongan' => 'Prodi - AK','keterangan' => ''],
            ['nama_golongan' => 'Prodi - MN','keterangan' => ''],
            ['nama_golongan' => 'Prodi - PBM','keterangan' => ''],
            ['nama_golongan' => 'Prodi - SI','keterangan' => ''],
            ['nama_golongan' => 'Prodi - SM','keterangan' => ''],
            ['nama_golongan' => 'Prodi - ST','keterangan' => ''],
            ['nama_golongan' => 'Prodi - TI','keterangan' => ''],
            ['nama_golongan' => 'Prodi - TIF','keterangan' => ''],
            ['nama_golongan' => 'Prodi - TL','keterangan' => ''],
            ['nama_golongan' => 'Prodi - TPL','keterangan' => '']
       ];
       GolMatakuliah::insert($records);
    }
}
