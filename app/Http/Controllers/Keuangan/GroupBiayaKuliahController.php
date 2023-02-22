<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\GroupBiayaKuliah;
use Response;
use Session;
use Validator;
use Auth;

class GroupBiayaKuliahController extends Controller
{
    public function index(Request $request)
    {
        $dataG = GroupBiayaKuliah::all();
        if($request->ajax()){
            return datatables()->of($dataG)
                ->addColumn('action', function($data){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Edit" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                    return $button;
                })->addColumn('setting', function($data){
                    return '<a href="'.Route('set-detail-biaya',['id' => $data->id]).'" name="detail_biaya" class="dropdown-shortcuts-add text-body detail_biaya" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Set Disc."><span class="badge bg-label-warning me-1"><i class="bx bx-xs bx-plus-circle bx-tada"></i> Set Detail</span></a>';
                })
                ->rawColumns(['action','setting'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('keuangan.g-biaya-kuliah.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year_level'  => 'required',
            'group_name'  => 'required',
        ],[
            'year_level.required'      => 'Anda belum memilih tahun angkatan',
            'group_name.required'      => 'Anda belum menginputkan tgl deadline'
        ]);

        $post = GroupBiayaKuliah::updateOrCreate(['id' => $request->id],
                [
                    'year_level'    => $request->year_level,
                    'group_name'    => $request->group_name,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = GroupBiayaKuliah::where($where)->first();     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = GroupBiayaKuliah::where('id',$id)->delete();     
        return response()->json($post);
    }
}
