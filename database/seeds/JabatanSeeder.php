<?php

use Illuminate\Database\Seeder;
use App\Model\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','id_periode' => 1,'kode_jabatan'=> 'DAK','nama_in' => 'Akademik','golongan' => 1],
            ['id' => '2','id_periode' => 1,'kode_jabatan'=> 'DKN','nama_in' => 'Dekan','golongan' => 2],
            ['id' => '3','id_periode' => 1,'kode_jabatan'=> 'KPD','nama_in' => 'Koprodi','golongan' => 2],
            ['id' => '4','id_periode' => 1,'kode_jabatan'=> 'KPG','nama_in' => 'Kepegawaian','golongan' => 1],
            ['id' => '5','id_periode' => 1,'kode_jabatan'=> 'KU','nama_in' => 'Keuangan','golongan' => 1],
            ['id' => '6','id_periode' => 1,'kode_jabatan'=> 'DSN','nama_in' => 'Dosen','golongan' => 2],
            ['id' => '7','id_periode' => 1,'kode_jabatan'=> 'A.DAK','nama_in' => 'Admin Akademik','golongan' => 1]
       ];
       Jabatan::insert($records);
    }
}
