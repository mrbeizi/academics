<?php

namespace App\Imports\Keuangan;

use App\Model\Keuangan\Payment;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class ImportPayment implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Payment([
            'nim_mahasiswa' => $row[1],
            'id_payment_list' => $row[2], 
            'jumlah_bayar' => $row[3],
            'tgl_pembayaran' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4])->format('Y-m-d'),
            'keterangan' => $row[5],
        ]);
    }
}
