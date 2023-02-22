<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\DetailBiayaKuliah;
use Response;
use Session;
use Validator;
use Auth;
use DB;

class DetailBiayaKuliahController extends Controller
{
    public function index(Request $request, $id)
    {
        $getProdi = DB::table('prodis')->select('id','nama_id')->where('is_archived',0)->get();
        $getGroupName = DB::table('group_biaya_kuliahs')->where('id',$id)->get();
        return view('keuangan.detail-biaya-kuliah.index',['id' => $id,'getGroupName' => $getGroupName,'getProdi' => $getProdi]);
    }

    public function listDetail(Request $request, $id)
    {
        $dataDetails = DetailBiayaKuliah::leftJoin('group_biaya_kuliahs','group_biaya_kuliahs.id','=','detail_biaya_kuliahs.id_group_biaya_kuliah')
            ->leftJoin('prodis','prodis.id','=','detail_biaya_kuliahs.id_lingkup_biaya')
            ->select('detail_biaya_kuliahs.id AS id','detail_biaya_kuliahs.nilai','group_biaya_kuliahs.group_name AS nama_group','prodis.nama_id AS nama_prodi')
            ->where('group_biaya_kuliahs.id',$id)
            ->get();
        if($request->ajax()){
            return datatables()->of($dataDetails)
                ->addColumn('action', function($data){
                        return '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('keuangan.detail-biaya-kuliah.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_lingkup_biaya'  => 'required',
            'nilai'             => 'required',
        ],[
            'id_lingkup_biaya.required' => 'Anda belum memilih prodi',
            'nilai.required'            => 'Anda belum menginputkan biaya'
        ]);

        $post  = DetailBiayaKuliah::updateOrCreate(['id' => $request->id],
                [
                    'id_group_biaya_kuliah' => $request->id_group_biaya_kuliah,
                    'id_lingkup_biaya'      => $request->id_lingkup_biaya,
                    'nilai'                 => preg_replace('/\D/','', $request->nilai),
                ]);
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = DetailBiayaKuliah::where('id',$id)->delete();     
        return response()->json($post);
    }
}
