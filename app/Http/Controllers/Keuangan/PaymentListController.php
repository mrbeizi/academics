<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\PaymentList;
use Response;
use Session;
use Validator;
use Auth;

class PaymentListController extends Controller
{
    public function index(Request $request)
    {
        $dataPaymentList = PaymentList::all();
                
        if($request->ajax()){
            return datatables()->of($dataPaymentList)
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
        return view('keuangan.payment-list.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembayaran'           => 'required',
        ],[
            'nama_pembayaran.required'       => 'Anda belum mamasukkan nama pembayaran'
        ]);

        $post   =   PaymentList::updateOrCreate(['id' => $request->id],
                    [
                        'nama_pembayaran'     => $request->nama_pembayaran
                    ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = PaymentList::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = PaymentList::where('id',$id)->delete();     
        return response()->json($post);
    }
}
