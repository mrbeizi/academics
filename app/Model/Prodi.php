<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $guarded = [];

    static function getArchivedProdi()
    {
        $datas = Prodi::leftJoin('periodes','periodes.id','=','prodis.id_periode')
            ->leftJoin('fakultas','fakultas.id','=','prodis.id_fakultas')
            ->select('prodis.id AS id','prodis.*','periodes.nama_periode','fakultas.nama_id AS nama_fakultas')
            ->where('prodis.is_archived','=',1)
            ->get();
        return $datas;
    }
}
