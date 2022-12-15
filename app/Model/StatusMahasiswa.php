<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StatusMahasiswa extends Model
{
    protected $guarded = [];

    static function getArchivedStatusMahasiswa()
    {
        $datas = StatusMahasiswa::select('*')->where('is_archived','=',1)->get();
        return $datas;
    }
}
