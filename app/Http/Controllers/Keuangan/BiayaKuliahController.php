<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\BiayaKuliah;
use App\Model\Keuangan\CustomBiaya;
use App\Model\Keuangan\SetupBiaya;
use App\Model\Keuangan\DiscountBiaya;
use App\Model\Mahasiswa;
use App\Model\Periode;
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
            ->where('periodes.is_active',1)
            ->get();
        if($request->ajax()){
            return datatables()->of($dataBiaya)
                ->addIndexColumn(true)
                ->make(true);
        }
        $getMahasiswa = Mahasiswa::leftJoin('prodis','prodis.id','=','mahasiswas.id_prodi')
            ->select('mahasiswas.id AS id','mahasiswas.no_form','mahasiswas.nim','mahasiswas.nama_mahasiswa','prodis.nama_id AS nama_prodi')
            ->get();
        $getPeriode = Periode::where('is_active',1)->get();
        // get Payment List from Discount table
        $getPaymentList = SetupBiaya::leftJoin('prodis','prodis.id','=','setup_biayas.id_lingkup_biaya')
            ->leftJoin('periodes','periodes.id','=','setup_biayas.id_periode')
            ->leftJoin('discount_biayas','discount_biayas.id_setup_biaya','=','setup_biayas.id')
            ->select('setup_biayas.id AS id_biaya','setup_biayas.nilai','setup_biayas.*','prodis.nama_id','periodes.kode','periodes.nama_periode','discount_biayas.id AS id_discount','discount_biayas.*')
            ->where('periodes.is_active','=',1)
            ->get();
        return view('keuangan.biaya-kuliah.index', compact('getMahasiswa','getPeriode','getPaymentList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim'           => 'required',
            'id_periode'    => 'required',
            'biaya'         => 'required',
        ],[
            'nim.required'         => 'Anda belum menginputkan nim',
            'id_periode.required'  => 'Anda belum memilih periode',
            'biaya.required'       => 'Anda belum memilih biaya'
        ]);

        $post = BiayaKuliah::updateOrCreate(['id' => $request->id],
                [
                    'nim'           => $request->nim,
                    'id_periode'    => $request->id_periode,
                    'biaya'         => $request->biaya,
                ]); 

        return response()->json($post);
    }
}
