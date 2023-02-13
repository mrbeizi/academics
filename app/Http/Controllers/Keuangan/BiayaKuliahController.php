<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\BiayaKuliah;
use App\Model\Keuangan\Payment;
use Response;
use Session;
use Validator;
use Auth;

class BiayaKuliahController extends Controller
{
    public function index(Request $request)
    {
        $dataBiaya = BiayaKuliah::leftJoin('mahasiswas','mahasiswas.nim','=','biaya_kuliahs.nim')
            ->leftJoin('periodes','periodes.id','=','biaya_kuliahs.id_periode')
            ->leftJoin('prodis','prodis.id','=','mahasiswas.id_prodi')
            ->select('biaya_kuliahs.id AS id','biaya_kuliahs.*','periodes.kode','periodes.nama_periode','prodis.nama_id','mahasiswas.nim AS nim','mahasiswas.nama_mahasiswa','mahasiswas.id_status_mahasiswa')
            ->get();
        if($request->ajax()){
            return datatables()->of($dataBiaya)
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('keuangan.biaya-kuliah.index');
    }
}
