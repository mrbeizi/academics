<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    protected $guarded = [];

    static function getArchivedKurikulum()
    {
        $datas = Kurikulum::leftJoin('prodis','prodis.id','=','kurikulums.id_prodi')
            ->leftJoin('periodes','periodes.id','=','kurikulums.id_periode')
            ->select('kurikulums.id AS id','kurikulums.*','prodis.nama_id AS nama_prodi','periodes.nama_periode')
            ->where('kurikulums.is_archived','=',1)
            ->get();
        return $datas;
    }
}
