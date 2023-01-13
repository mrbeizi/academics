<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\MatakuliahKurikulum;
use App\Model\GolMatakuliah;
use App\Model\Matakuliah;
use App\Model\Kurikulum;
use App\Model\Periode;
use App\Model\Prodi;

class MatakuliahKurikulumController extends Controller
{
    public function index(Request $request, $id)
    {
        $dataMatakuliah = MatakuliahKurikulum::leftJoin('kurikulums','kurikulums.id','=','matakuliah_kurikulums.id_kurikulum')
            ->leftJoin('periodes','periodes.id','=','kurikulums.id_periode')
            ->leftJoin('matakuliahs','matakuliahs.kode','=','matakuliah_kurikulums.kode_matakuliah')
            ->select('matakuliah_kurikulums.id AS id','matakuliah_kurikulums.*','kurikulums.nama','matakuliahs.nama_id')
            ->where('periodes.is_active','=',1)
            ->get();

        $dataKurikulum = Kurikulum::leftJoin('periodes','periodes.id','=','kurikulums.id_periode')
            ->select('kurikulums.id AS id_kur','kurikulums.*','periodes.nama_periode')
            ->where([['kurikulums.id','=',$id],['periodes.is_active','=',1]])
            ->get();

        /* Get the subjects with conditions:
            - First, get the kurikulum id
            - Then, get the prodi id
            - get data from gol matakuliah and put in an array as golongan

        */
        
        $kurikulum = Kurikulum::where('id',$id)->first();
        $prodi = Prodi::where('id',$kurikulum->id_prodi)->first();
        $golonganMatkul = GolMatakuliah::all();
        $golongan=array();
        foreach ($golonganMatkul as $key => $item) {
            if ($prodi->id == $item->id_prodi || $prodi->id_fakultas == $item->id_fakultas || $item->id == 1) {
                array_push($golongan, $item->id);
            }
        }
        
        $getS = MatakuliahKurikulum::select('kode_matakuliah')->where('id_kurikulum','=',$id)->get();
        $getR = Kurikulum::where('id',$id)->get();
        
        foreach ($getR as $data) {
            $getMatakuliah = Matakuliah::leftJoin('gol_matakuliahs','gol_matakuliahs.id','=','matakuliahs.golongan_matakuliah')
            ->whereIn('gol_matakuliahs.id', $golongan)
            ->whereNotIn('kode',$getS)
            ->where('is_active',1)
            ->get();
        }
        /* End of get subject with conditions */

        // Start to get matakuliah according to id kurikulum and id prodi -- select datas where not in matakuliah kurikulum
        /*
            $getS = MatakuliahKurikulum::select('kode_matakuliah')->where('id_kurikulum','=',$id)->get();
            $getR = Kurikulum::leftJoin('gol_matakuliahs','gol_matakuliahs.id_prodi','=','kurikulums.id_prodi')
                ->select('gol_matakuliahs.id')
                ->where('kurikulums.id','=',$id)
                ->get();

            foreach($getR as $data){
                $getMatakuliah = Matakuliah::whereNotIn('kode',$getS)->where([['is_active','=',1],['golongan_matakuliah','=',$data->id]])->get();        
            }
        */
        // End of get data matakuliah

        $getKurikulum = Kurikulum::where('is_active','=',1)->get();

        return view('administrator.mk-kurikulum.index', ['id' => $id, 'dataMatakuliah' => $dataMatakuliah, 'dataKurikulum' => $dataKurikulum, 'getMatakuliah' => $getMatakuliah,'getKurikulum' => $getKurikulum]);
    }

    public function listMK(Request $request, $id)
    {            
        $getData = MatakuliahKurikulum::leftJoin('kurikulums','kurikulums.id','=','matakuliah_kurikulums.id_kurikulum')
        ->leftJoin('periodes','periodes.id','=','kurikulums.id_periode')
        ->leftJoin('matakuliahs','matakuliahs.kode','=','matakuliah_kurikulums.kode_matakuliah')
        ->select('matakuliah_kurikulums.id AS id','matakuliah_kurikulums.*','kurikulums.nama','matakuliahs.nama_id','matakuliahs.sks_teori','matakuliahs.sks_praktek')
        ->where([['kurikulums.id','=',$id],['periodes.is_active','=',1]])
        ->get();

        if($request->ajax()){
            return datatables()->of($getData)
                ->addColumn('action', function($data){
                   return '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('administrator.mk-kurikulum.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kurikulum'              => 'required',
            'kode_matakuliah'           => 'required',
            'semester'                  => 'required|numeric|min:1|max:14',
        ],[
            'id_kurikulum.required'     => 'Anda belum memilih kurikulum',
            'kode_matakuliah.required'  => 'Anda belum memilih matakuliah',
            'semester.required'         => 'Anda belum mengisi kolom semester',
            'semester.min'              => 'Semester minimal >= 1',
            'semester.max'              => 'Semester maksimal <= 14'
        ]);

        $isWajib = $request->input('wajib');
        if($isWajib == null) { $isWajib = $request->input('wajib') ?? 0; } 
        else { $isWajib = $request->input('wajib') ?? 1; }

        $post = MatakuliahKurikulum::updateOrCreate(['id' => $request->id],
                [
                    'id_kurikulum'      => $request->id_kurikulum,
                    'kode_matakuliah'   => $request->kode_matakuliah,
                    'wajib'             => $isWajib,
                    'semester'          => $request->semester
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = MatakuliahKurikulum::where($where)->first();
     
        return response()->json($post);
    }

    public function switchMatakuliah(Request $request)
    {
        $req    = $request->is_active == '1' ? 0 : 1;
        $post   = MatakuliahKurikulum::updateOrCreate(['id' => $request->id],['is_active' => $req]); 
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = MatakuliahKurikulum::where('id',$id)->delete();     
        return response()->json($post);
    }
}
