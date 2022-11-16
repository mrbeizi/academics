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

    static function getArchivedJabatanPegawai()
    {
        $datas = JabatanPegawai::leftJoin('jabatans','jabatans.id','=','jabatan_pegawais.id_jabatan')
            ->leftJoin('pegawais','pegawais.id','=','jabatan_pegawais.id_pegawai')
            ->leftJoin('periodes','periodes.id','=','jabatan_pegawais.id_periode')
            ->select('jabatan_pegawais.id AS id','jabatan_pegawais.*','jabatans.kode_jabatan','jabatans.nama_in AS nama_jabatan','pegawais.nama_in AS nama_pegawai','periodes.nama_periode')
            ->where('jabatan_pegawais.is_archived','=',1)
            ->get();
        return $datas;
    }
}
