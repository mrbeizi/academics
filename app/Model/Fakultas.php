<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $guarded = [];

    static function getArchivedFakultas()
    {
        $datas = Fakultas::leftJoin('periodes','periodes.id','=','fakultas.id_periode')
            ->select('fakultas.id AS id','fakultas.*','periodes.nama_periode')
            ->where('fakultas.is_archived','=',1)
            ->get();
        return $datas;
    }
}
