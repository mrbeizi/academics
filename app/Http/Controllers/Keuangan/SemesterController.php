<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\Semester;
use Response;
use Session;
use Validator;
use Auth;

class SemesterController extends Controller
{
    public function index(Request $request)
    {
        $dataSemester = Semester::all();
                
        if($request->ajax()){
            return datatables()->of($dataSemester)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Edit" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('keuangan.semester.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_semester'           => 'required',
        ],[
            'nama_semester.required'       => 'Anda belum mamasukkan nama semester'
        ]);

        $post   =   Semester::updateOrCreate(['id' => $request->id],
                    [
                        'nama_semester'     => $request->nama_semester
                    ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Semester::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Semester::where('id',$id)->delete();     
        return response()->json($post);
    }
}
