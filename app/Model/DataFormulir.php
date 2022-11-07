<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DataFormulir extends Model
{
    protected $guarded = [];

    static function getArchivedDataFormulir()
    {
        $datas = DataFormulir::leftJoin('periodes','periodes.id','=','data_formulirs.id_periode')
            ->select('data_formulirs.id AS id','data_formulirs.*','periodes.nama_periode')
            ->where('data_formulirs.is_archived','=',1)
            ->get();
        return $datas;
    }
}
