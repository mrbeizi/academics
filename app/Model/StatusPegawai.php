<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StatusPegawai extends Model
{
    protected $guarded = [];

    static function getArchivedStatusPegawai()
    {
        $datas = StatusPegawai::select('*')->where('is_archived','=',1)->get();
        return $datas;
    }
}
