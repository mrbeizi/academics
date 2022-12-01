<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Pegawai;
use App\Model\StatusPegawai;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $dataPegawai = Pegawai::all();
                
        if($request->ajax()){
            return datatables()->of($dataPegawai)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getStatusPegawai = StatusPegawai::all();
        return view('administrator.pegawai.index', compact('getStatusPegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'               => 'required',
            'nama_in'           => 'required',
            'jenis_kelamin'     => 'required',
            'tempat_lahir'      => 'required',
            'tanggal_lahir'     => 'required',
            'agama'             => 'required',
            'id_status_pegawai' => 'required',
            'tanggal_masuk'     => 'required',
        ],[
            'nip.required'               => 'Anda belum menginputkan nip',
            'nama_in.required'           => 'Anda belum menginputkan nama',
            'jenis_kelamin.required'     => 'Anda belum memilih jenis kelamin',
            'tempat_lahir.required'      => 'Anda belum menginputkan tempat lahir',
            'tanggal_lahir.required'     => 'Anda belum menginputkan tanggal lahir',
            'agama.required'             => 'Anda belum memilih agama',
            'id_status_pegawai.required' => 'Anda belum memilih status',
            'tanggal_masuk.required'     => 'Anda belum menginputkan tanggal masuk'
        ]);

        $post = Pegawai::updateOrCreate(['id' => $request->id],
                [
                    'nip'               => $request->nip,
                    'nama_in'           => $request->nama_in,
                    'nama_ch'           => $request->nama_ch,
                    'jenis_kelamin'     => $request->jenis_kelamin,
                    'tempat_lahir'      => $request->tempat_lahir,
                    'tanggal_lahir'     => $request->tanggal_lahir,
                    'agama'             => $request->agama,
                    'id_status_pegawai' => $request->id_status_pegawai,
                    'tanggal_masuk'     => $request->tanggal_masuk
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Pegawai::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Pegawai::where('id',$id)->delete();     
        return response()->json($post);
    }
}
