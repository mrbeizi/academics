<?php

use Illuminate\Database\Seeder;
use App\Model\Keuangan\SetupBiaya;

class SetupBiayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','nama_biaya' => 'Jas Almamater dan Administrasi','id_lingkup_biaya' => '0','nilai' => '600000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:29:37','updated_at' => '2023-02-06 14:38:52'],
            ['id' => '2','nama_biaya' => 'SPP Tetap','id_lingkup_biaya' => '0','nilai' => '4000000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:39:13','updated_at' => '2023-02-06 14:39:13'],
            ['id' => '3','nama_biaya' => 'SPP Sks Semester 1','id_lingkup_biaya' => '1','nilai' => '3600000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:39:55','updated_at' => '2023-02-06 14:39:55'],
            ['id' => '4','nama_biaya' => 'SPP Sks Semester 1','id_lingkup_biaya' => '2','nilai' => '3600000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:40:45','updated_at' => '2023-02-06 14:40:45'],
            ['id' => '5','nama_biaya' => 'SPP Sks Semester 1','id_lingkup_biaya' => '3','nilai' => '3420000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:41:02','updated_at' => '2023-02-06 14:41:02'],
            ['id' => '6','nama_biaya' => 'SPP Sks Semester 1','id_lingkup_biaya' => '4','nilai' => '3240000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:41:21','updated_at' => '2023-02-06 14:41:21'],
            ['id' => '7','nama_biaya' => 'SPP Sks Semester 1','id_lingkup_biaya' => '10','nilai' => '4600000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:41:39','updated_at' => '2023-02-06 14:41:39'],
            ['id' => '8','nama_biaya' => 'SPP Sks Semester 1','id_lingkup_biaya' => '5','nilai' => '3600000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:41:56','updated_at' => '2023-02-06 14:41:56'],
            ['id' => '9','nama_biaya' => 'SPP Sks Semester 1','id_lingkup_biaya' => '6','nilai' => '3600000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:42:11','updated_at' => '2023-02-06 14:42:11'],
            ['id' => '10','nama_biaya' => 'SPP Sks Semester 1','id_lingkup_biaya' => '7','nilai' => '3600000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:42:26','updated_at' => '2023-02-06 14:42:26'],
            ['id' => '11','nama_biaya' => 'SPP Sks Semester 1','id_lingkup_biaya' => '8','nilai' => '3600000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:42:45','updated_at' => '2023-02-06 14:42:45'],
            ['id' => '12','nama_biaya' => 'SPP Sks Semester 1','id_lingkup_biaya' => '9','nilai' => '3240000','id_periode' => '1','is_archived' => NULL,'created_at' => '2023-02-06 14:42:58','updated_at' => '2023-02-06 14:42:58']
        ];
        SetupBiaya::insert($records);
    }
}
