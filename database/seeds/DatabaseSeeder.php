<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            GolMatakuliahSeeder::class,
            PeriodeSeeder::class,
            FakultasSeeder::class,
            ProdiSeeder::class,
            DataFormulirSeeder::class,
            StatusPegawaiSeeder::class,
            JabatanSeeder::class,
            PegawaiSeeder::class,
            StatusMahasiswaSeeder::class,
            StatusKelasKuliahSeeder::class,
            SetupBiayaSeeder::class,
            PaymentListSeeder::class,
        ]);
    }
}
