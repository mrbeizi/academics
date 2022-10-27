<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    protected $guarded = [];

    static function getArchivedMatakuliah()
    {
        $datas = Matakuliah::leftJoin('periodes','periodes.id','=','matakuliahs.id_periode')
            ->select('matakuliahs.id AS id','matakuliahs.*','periodes.nama_periode')
            ->where('matakuliahs.is_archived','=',1)
            ->get();
        return $datas;
    }
}
