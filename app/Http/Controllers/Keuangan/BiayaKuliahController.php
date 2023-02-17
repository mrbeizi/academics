<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
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
            ->orderBy('prodis.id','ASC')
            ->get();
        return view('keuangan.biaya-kuliah.index',compact('getMahasiswa','getPeriode','getPaymentList'));
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

    public function importBiayaKuliah(Request $request)
    {
        $request->validate([
            'year_level'  => 'required',
            'custom_name' => 'required',
        ],[
            'year_level.required'  => 'Anda belum memilih angkatan',
            'custom_name.required' => 'Anda belum memilih periode'
        ]);

        // Check if data exists
        $isExist = BiayaKuliah::where([['nim','LIKE',''.$request->year_level.'%'],['id_periode','=',$request->custom_name]])->count();
        if($isExist < 1) {
            $collection = DiscountBiaya::leftJoin('setup_biayas','setup_biayas.id','=','discount_biayas.id_setup_biaya')
                ->leftJoin('custom_biayas','custom_biayas.id','=','discount_biayas.id_custom_biaya')
                ->leftJoin('prodis','prodis.id','=','setup_biayas.id_lingkup_biaya')
                ->leftJoin('mahasiswas','mahasiswas.id_prodi','=','prodis.id')
                ->leftJoin('periodes','periodes.id','=','setup_biayas.id_periode')
                ->select('discount_biayas.discount','discount_biayas.is_percentage','setup_biayas.nilai','setup_biayas.id_lingkup_biaya','prodis.nama_id','mahasiswas.nim','mahasiswas.nama_mahasiswa','mahasiswas.id_periode')
                ->where([['custom_biayas.id','=',$request->custom_name],['mahasiswas.nim','LIKE',$request->year_level.'%'],['setup_biayas.id_lingkup_biaya','!=',0]])
                ->get();
    
            // Check if data available in table mahasiswa
            if($collection->count() > 0){
                foreach($collection as $datas) {
                    if($datas->is_percentage == 1){
                        $cost = $datas->nilai - ($datas->discount * $datas->nilai/100);
                    } else {
                        $cost = $datas->nilai - $datas->discount;
                    }
        
                    $post = BiayaKuliah::updateOrCreate(['id' => $request->id],
                    [
                        'id_periode' => $request->custom_name,
                        'nim'        => $datas->nim,
                        'biaya'      => $cost,
                    ]);
                }
                return response()->json($post);
            } else {
                return Response::json(array('check' => 'not_available'), 200);
            }
        } else {
            return Response::json(array('check' => 'not_exist'), 200);
        }
    }
}
