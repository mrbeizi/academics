<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\BiayaKuliah;
use App\Model\Keuangan\CustomBiaya;
use App\Model\Keuangan\SetupBiaya;
use App\Model\Keuangan\DiscountBiaya;
use App\Model\Keuangan\DetailBiayaKuliah;
use App\Model\Mahasiswa;
use App\Model\Periode;
use Response;
use Session;
use Validator;
use Auth;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $dataBiaya = BiayaKuliah::leftJoin('mahasiswas','mahasiswas.nim','=','biaya_kuliahs.nim')
            ->leftJoin('periodes','periodes.id','=','biaya_kuliahs.id_periode')
            ->leftJoin('prodis','prodis.id','=','mahasiswas.id_prodi')
            ->select('biaya_kuliahs.id AS id','biaya_kuliahs.*','periodes.kode','periodes.nama_periode','prodis.nama_id','mahasiswas.nim AS nim','mahasiswas.nama_mahasiswa','mahasiswas.id_status_mahasiswa')
            ->where('periodes.is_active',1)
            ->orderBy('biaya_kuliahs.created_at','DESC')
            ->get();
        if($request->ajax()){
            return datatables()->of($dataBiaya)
                ->addColumn('action', function($data){
                    return '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                })
                ->rawColumns(['action'])
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
        return view('keuangan.invoice.index', compact('getMahasiswa','getPeriode','getPaymentList'));
    }

    public function importInvoice(Request $request)
    {
        $request->validate([
            'year_level'  => 'required',
            'custom_name' => 'required',
            'semester'    => 'required',
        ],[
            'year_level.required'  => 'Anda belum memilih angkatan',
            'custom_name.required' => 'Anda belum memilih periode',
            'semester.required'    => 'Anda belum menginputkan semester'
        ]);

        // Check if data exists
        $isExist = BiayaKuliah::where([['nim','LIKE',''.$request->year_level.'%'],['id_periode','=',$request->custom_name]])->count();
        if($isExist < 1) {
            $collectionSPP = DetailBiayaKuliah::leftJoin('group_biaya_kuliahs','group_biaya_kuliahs.id','=','detail_biaya_kuliahs.id_group_biaya_kuliah')
                ->leftJoin('prodis','prodis.id','=','detail_biaya_kuliahs.id_lingkup_biaya')
                ->leftJoin('mahasiswas','mahasiswas.id_prodi','=','prodis.id')
                ->where([['mahasiswas.nim','LIKE',$request->year_level.'%'],['group_biaya_kuliahs.year_level','LIKE',$request->year_level.'%'],['group_biaya_kuliahs.group_name','LIKE','%'."SPP".'%']])
                ->get();

            $collectionSKS = DetailBiayaKuliah::leftJoin('group_biaya_kuliahs','group_biaya_kuliahs.id','=','detail_biaya_kuliahs.id_group_biaya_kuliah')
                ->leftJoin('prodis','prodis.id','=','detail_biaya_kuliahs.id_lingkup_biaya')
                ->leftJoin('mahasiswas','mahasiswas.id_prodi','=','prodis.id')
                ->where([['mahasiswas.nim','LIKE',$request->year_level.'%'],['group_biaya_kuliahs.year_level','LIKE',$request->year_level.'%'],['group_biaya_kuliahs.group_name','LIKE','%'."SKS".'%']])
                ->get();

            if($collectionSKS->count() > 0){
                foreach($collectionSKS as $costSKS){
                    $totalCostSKS = $costSKS->nilai * 24; 
                    # 24 is temporary value, it should be a total of University Credit Unit (SKS)
                    # from each student according to the course selection sheet (KRS) which has been inputed
                }
            } else {
                $totalCostSKS = 0;
            }

            // Check if data available in table mahasiswa
            if($collectionSPP->count() > 0){
                foreach($collectionSPP as $datas) {
                    $post = BiayaKuliah::updateOrCreate(['id' => $request->id],
                    [
                        'id_periode' => $request->custom_name,
                        'nim'        => $datas->nim,
                        'biaya'      => $datas->nilai + $totalCostSKS,
                        'semester'   => $request->semester,
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
                    'semester'      => 'Semester 1',
                ]); 

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = BiayaKuliah::where('id',$id)->delete();     
        return response()->json($post);
    }
}
