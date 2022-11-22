<?php

use Illuminate\Database\Seeder;
use App\Model\Fakultas;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','id_periode' => 1,'nama_id' => 'Bisnis','nama_en' => 'Business','is_archived' => 0],
            ['id' => '2','id_periode' => 1,'nama_id' => 'Komputer','nama_en' => 'Computer','is_archived' => 0],
            ['id' => '3','id_periode' => 1,'nama_id' => 'Seni','nama_en' => 'Arts','is_archived' => 0],
            ['id' => '4','id_periode' => 1,'nama_id' => 'Teknik','nama_en' => 'Engineering','is_archived' => 0],
            ['id' => '5','id_periode' => 1,'nama_id' => 'Pendidikan, Bahasa dan Budaya','nama_en' => 'Education, Language and Culture','is_archived' => 0]
       ];
       Fakultas::insert($records);
    }
}
