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
        $this->call(UserSeeder::class);
        $this->call(GolMatakuliahSeeder::class);
        $this->call(PeriodeSeeder::class);
        $this->call(FakultasSeeder::class);
        $this->call(ProdiSeeder::class);
        $this->call(DataFormulirSeeder::class);
    }
}
