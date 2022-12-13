<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Model\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_EN');

        for($i = 1; $i <= 20; $i++){
 
            // insert data ke table pegawai menggunakan Faker
          Pegawai::insert([
              'nip' => $faker->numberBetween(100000,890000),
              'nama_in' => $faker->name,
              'jenis_kelamin' => $faker->numberBetween(1,2),
              'tempat_lahir' => $faker->country,
              'tanggal_lahir' => now(),
              'agama' => $faker->randomElement(["Buddha","Buddha Maitreya","Kristen","Katholik","Islam","Khonghucu","Other"]),
              'id_status_pegawai' => $faker->numberBetween(1,3),
              'tanggal_masuk' => now(),
          ]);

        }
    }
}
