<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JabatanPegawai extends Model
{
    protected $guarded = [];

    static function getJabatan()
    {
        $datas = JabatanPegawai::leftJoin('jabatans','jabatans.id','=','jabatan_pegawais.id_jabatan')
            ->select('jabatans.id AS id_jabatan','jabatans.kode_jabatan','jabatans.nama_in')
            ->get();
        return $datas;
    }

    static function getPegawai()
    {
        $datas = JabatanPegawai::leftJoin('pegawais','pegawais.id','=','jabatan_pegawais.id_pegawai')
            ->select('pegawais.id AS id_pegawai','pegawais.*')
            ->get();
        return $datas;
    }
}
