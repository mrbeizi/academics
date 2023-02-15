<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\DiscountBiaya;
use App\Model\Keuangan\CustomBiaya;
use App\Model\Keuangan\SetupBiaya;
use Response;
use Session;
use Validator;
use Auth;

class DiscountBiayaController extends Controller
{
    public function index(Request $request,$id)
    {
        $dataDiscountBiaya = DiscountBiaya::all();                
        if($request->ajax()){
            return datatables()->of($dataDiscountBiaya)
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
        $getPaymentList = SetupBiaya::leftJoin('prodis','prodis.id','=','setup_biayas.id_lingkup_biaya')
            ->leftJoin('periodes','periodes.id','=','setup_biayas.id_periode')
            ->select('setup_biayas.id AS id_biaya','setup_biayas.*','prodis.nama_id','periodes.kode','periodes.nama_periode')
            ->get();
        $getCustomName = CustomBiaya::where('id',$id)->select('nama_custom_biaya')->get();
        return view('keuangan.discount-biaya.index',['id'=>$id,'getPaymentList' => $getPaymentList,'getCustomName' => $getCustomName]);
    }

    public function listDiscount(Request $request, $id)
    {
        $dataDiscountBiaya = DiscountBiaya::leftJoin('setup_biayas','setup_biayas.id','=','discount_biayas.id_setup_biaya')
            ->leftJoin('periodes','periodes.id','=','setup_biayas.id_periode')
            ->leftJoin('prodis','prodis.id','=','setup_biayas.id_prodi')
            ->select('discount_biayas.id AS id','discount_biayas.*','setup_biayas.nama_biaya','setup_biayas.nilai','periodes.nama_periode','prodis.nama_id')  
            ->where('custom_biayas.id','=',$id)
            ->get();            
        if($request->ajax()){
            return datatables()->of($dataDiscountBiaya)
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
        return view('keuangan.discount-biaya.index');
    }
}
