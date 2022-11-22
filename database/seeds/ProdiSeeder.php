<?php

use Illuminate\Database\Seeder;
use App\Model\Prodi;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','id_periode' => 1,'id_fakultas'=> 3,'kode_dikti' => '91231','kode_nim' => '111','kode_prodi' => 'ST','nama_en' => 'Dance','nama_id' => 'Seni Tari','jenjang' => 'S1','is_archived' => 0],
            ['id' => '2','id_periode' => 1,'id_fakultas'=> 3,'kode_dikti' => '91221','kode_nim' => '112','kode_prodi' => 'SM','nama_en' => 'Music','nama_id' => 'Seni Musik','jenjang' => 'S1','is_archived' => 0],
            ['id' => '3','id_periode' => 1,'id_fakultas'=> 1,'kode_dikti' => '61201','kode_nim' => '121','kode_prodi' => 'MN','nama_en' => 'Management','nama_id' => 'Manajemen','jenjang' => 'S1','is_archived' => 0],
            ['id' => '4','id_periode' => 1,'id_fakultas'=> 1,'kode_dikti' => '62201','kode_nim' => '122','kode_prodi' => 'AK','nama_en' => 'Accounting','nama_id' => 'Akuntansi','jenjang' => 'S1','is_archived' => 0],
            ['id' => '5','id_periode' => 1,'id_fakultas'=> 2,'kode_dikti' => '55202','kode_nim' => '131','kode_prodi' => 'TIF','nama_en' => 'Informatics','nama_id' => 'Teknik Informatika','jenjang' => 'S1','is_archived' => 0],
            ['id' => '6','id_periode' => 1,'id_fakultas'=> 2,'kode_dikti' => '57201','kode_nim' => '132','kode_prodi' => 'SI','nama_en' => 'Information System','nama_id' => 'Sistem Informasi','jenjang' => 'S1','is_archived' => 0],
            ['id' => '7','id_periode' => 1,'id_fakultas'=> 2,'kode_dikti' => '58201','kode_nim' => '133','kode_prodi' => 'TPL','nama_en' => 'Software Engineering','nama_id' => 'Teknik Perangkat Lunak','jenjang' => 'S1','is_archived' => 0],
            ['id' => '8','id_periode' => 1,'id_fakultas'=> 4,'kode_dikti' => '26201','kode_nim' => '141','kode_prodi' => 'TI','nama_en' => 'Industrial Engineering','nama_id' => 'Teknik Industri','jenjang' => 'S1','is_archived' => 0],
            ['id' => '9','id_periode' => 1,'id_fakultas'=> 4,'kode_dikti' => '25201','kode_nim' => '142','kode_prodi' => 'TL','nama_en' => 'Environmental Engineering','nama_id' => 'Teknik Lingkungan','jenjang' => 'S1','is_archived' => 0],
            ['id' => '10','id_periode' => 1,'id_fakultas'=> 5,'kode_dikti' => '88208','kode_nim' => '151','kode_prodi' => 'PBM','nama_en' => 'Chinese Language Education','nama_id' => 'Pendidikan Bahasa Mandarin','jenjang' => 'S1','is_archived' => 0]
       ];
       Prodi::insert($records);
    }
}
