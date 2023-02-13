<?php

use Illuminate\Database\Seeder;
use App\Model\Keuangan\PaymentList;

class PaymentListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['nama_pembayaran' => 'Uang SPP','created_at' => '2023-02-06 14:29:37','updated_at' => '2023-02-06 14:38:52'],
            ['nama_pembayaran' => 'Uang Lab','created_at' => '2023-02-06 14:29:37','updated_at' => '2023-02-06 14:38:52'],
            ['nama_pembayaran' => 'Uang Cuti','created_at' => '2023-02-06 14:29:37','updated_at' => '2023-02-06 14:38:52'],
            ['nama_pembayaran' => 'Uang Aktif Kembali','created_at' => '2023-02-06 14:29:37','updated_at' => '2023-02-06 14:38:52'],
            ['nama_pembayaran' => 'Lain-lain','created_at' => '2023-02-06 14:29:37','updated_at' => '2023-02-06 14:38:52']
        ];
        PaymentList::insert($records);
    }
}
