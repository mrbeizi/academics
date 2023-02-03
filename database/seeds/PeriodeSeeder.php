<?php

use Illuminate\Database\Seeder;
use App\Model\Periode;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id' => '1','kode' => '20231','nama_periode' => 'Semester Ganjil','is_active' => '1','input_nilai' => 1,'temp_open' => 1,'finish' => 0]
       ];
       Periode::insert($records);
    }
}
