<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Kurikulum;
use App\Model\MatakuliahKurikulum;
use App\Model\Periode;
use App\Model\Prodi;
use DB;

class KurikulumController extends Controller
{
    public function index(Request $request)
    {
        $dataKurikulum = Kurikulum::leftJoin('prodis','prodis.id','=','kurikulums.id_prodi')
            ->leftJoin('periodes','periodes.id','=','kurikulums.id_periode')
            ->select('kurikulums.id AS id','kurikulums.*','prodis.nama_id AS nama_prodi','periodes.nama_periode','kurikulums.is_active AS is_active')
            ->where([['periodes.is_active','=',1],['kurikulums.is_archived','=',0]])
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataKurikulum)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" name="archive-kurikulum" data-toggle="tooltip" data-placement="bottom" title="Archive" onclick="archiveKurikulum('.$data->id.','.$data->is_archived.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="archivekurikulum" class="archivekurikulum btn btn-warning btn-xs archive-post"><i class="bx bx-xs bx-archive"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })->addColumn('status', function($data){
                    return '<div class="custom-control">
                    <label class="switch switch-primary" for="'.$data->id.'">
                    <input type="checkbox" class="switch-input" onclick="KurikulumStatus('.$data->id.','.$data->is_active.')" name="kurikulum-status" id="'.$data->id.'" '.(($data->is_active=='1')?'checked':"").'>
                    <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span></label></div>';
                })->addColumn('setting', function($data){
                    return '<a href="'.Route('setting.mkkurikulum',['id' => $data->id]).'" name="setting" class="dropdown-shortcuts-add text-body setting" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add MK Kurikulum"><i class="bx bx-sm bx-plus-circle bx-tada"></i> '.$data->nama.'</a>';
                })->addColumn('total_sks', function($data){
                    $total = $this->countWeight($data->id);
                    return ($total == null) ? '0 SKS' : $total .' SKS';
                })
                ->rawColumns(['action','status','setting','total_sks'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getPeriode = Periode::where('is_active','=',1)->get();
        $getProdi = Prodi::where('is_archived','=',0)->get();
        return view('administrator.kurikulum.index', compact('getPeriode','getProdi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required',
            'id_prodi'   => 'required',
            'id_periode' => 'required',
        ],[
            'nama.required'       => 'Anda belum menginputkan nama', 
            'id_prodi.required'   => 'Anda belum memilih prodi',
            'id_periode.required' => 'Anda belum memilih periode'
        ]);

        $post = Kurikulum::updateOrCreate(['id' => $request->id],
                [
                    'nama'        => $request->nama,
                    'id_prodi'    => $request->id_prodi,
                    'id_periode'  => $request->id_periode,
                    'is_active'   => 1,
                    'is_archived' => 0
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Kurikulum::where($where)->first();
     
        return response()->json($post);
    }

    public function switchKurikulum(Request $request)
    {
        $req    = $request->is_active == '1' ? 0 : 1;
        $post   = Kurikulum::updateOrCreate(['id' => $request->id],['is_active' => $req]); 
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Kurikulum::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function archiveKurikulum(Request $request)
    {
        $req    = $request->is_archived == '1' ? 0 : 1;
        $post   = Kurikulum::updateOrCreate(['id' => $request->id],['is_archived' => $req],['archived_at' => now()]); 
        return response()->json($post);
    }

    protected function countWeight($id_kurikulum)
    {
        $datas = MatakuliahKurikulum::leftJoin('matakuliahs','matakuliahs.kode','=','matakuliah_kurikulums.kode_matakuliah')
            ->leftJoin('kurikulums','kurikulums.id','=','matakuliah_kurikulums.id_kurikulum')
            ->select(DB::raw('sum(matakuliahs.sks_teori + matakuliahs.sks_praktek) as total'))
            ->where('kurikulums.id','=',$id_kurikulum)
            ->first();
        return $datas->total;
    }

    public function show(Request $request)
    {        
        if($request->ajax()){
            return datatables()->of(Kurikulum::getArchivedKurikulum())
                ->addColumn('action', function($data){
                        return '<a href="javascript:void(0)" name="unarchive-kurikulum" data-toggle="tooltip" data-placement="bottom" title="Unarchive" onclick="unarchiveKurikulum('.$data->id.','.$data->is_archived.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="unarchivekurikulum" class="archivekurikulum unarchive-post"><i class="bx bx-sm bx-archive-out"></i></a>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('administrator.kurikulum.index');
    }

    public function unarchiveKurikulum(Request $request)
    {
        $req    = $request->is_archived == '1' ? 0 : 1;
        $post   = Kurikulum::updateOrCreate(['id' => $request->id],['is_archived' => $req]); 
        return response()->json($post);
    }
}
