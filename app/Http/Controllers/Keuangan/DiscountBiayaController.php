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
        $dataDiscountBiaya = DiscountBiaya::leftJoin('setup_biayas','setup_biayas.id','=','discount_biayas.id_setup_biaya')
            ->leftJoin('custom_biayas','custom_biayas.id','=','discount_biayas.id_custom_biaya')
            ->leftJoin('periodes','periodes.id','=','setup_biayas.id_periode')
            ->leftJoin('prodis','prodis.id','=','setup_biayas.id_lingkup_biaya')
            ->select('discount_biayas.id AS id','discount_biayas.*','setup_biayas.id_lingkup_biaya','setup_biayas.nama_biaya','setup_biayas.nilai','periodes.nama_periode','prodis.nama_id AS nama_prodi','custom_biayas.nama_custom_biaya')  
            ->where('setup_biayas.id','=',$id)
            ->get();     
        $getPaymentList = SetupBiaya::leftJoin('prodis','prodis.id','=','setup_biayas.id_lingkup_biaya')
            ->leftJoin('periodes','periodes.id','=','setup_biayas.id_periode')
            ->select('setup_biayas.id AS id_biaya','setup_biayas.*','prodis.nama_id','periodes.kode','periodes.nama_periode')
            ->where('periodes.is_active','=',1)
            ->get();
        $getCustomName = CustomBiaya::where('id',$id)->select('id','nama_custom_biaya')->get();
        return view('keuangan.discount-biaya.index',['id'=>$id,'getPaymentList' => $getPaymentList,'getCustomName' => $getCustomName]);
    }

    public function listDiscount(Request $request, $id)
    {
        $dataDiscountBiaya = DiscountBiaya::leftJoin('setup_biayas','setup_biayas.id','=','discount_biayas.id_setup_biaya')
            ->leftJoin('custom_biayas','custom_biayas.id','=','discount_biayas.id_custom_biaya')
            ->leftJoin('periodes','periodes.id','=','setup_biayas.id_periode')
            ->leftJoin('prodis','prodis.id','=','setup_biayas.id_lingkup_biaya')
            ->select('discount_biayas.id AS id','discount_biayas.*','setup_biayas.id_lingkup_biaya','setup_biayas.nama_biaya','setup_biayas.nilai','periodes.nama_periode','prodis.nama_id AS nama_prodi','custom_biayas.nama_custom_biaya')
            ->where('discount_biayas.id_custom_biaya',$id)  
            ->get();            
        if($request->ajax()){
            return datatables()->of($dataDiscountBiaya)
                ->addColumn('action', function($data){
                        return '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('keuangan.discount-biaya.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_setup_biaya'    => 'required',
            'discount'          => 'required',
        ],[
            'id_setup_biaya.required' => 'Anda belum memilih lingkup biaya',
            'discount.required'       => 'Anda belum menginputkan jumlah potongan'
        ]);

        $percentage = $request->input('is_percentage');
        if($percentage == null) { $percentage = $request->input('is_percentage') ?? 0; } 
        else { $percentage = $request->input('is_percentage') ?? 1; }
      
        $id = $request->id;
        $post  = DiscountBiaya::updateOrCreate(['id' => $id],
                [
                    'id_custom_biaya'      => $request->id_custom_biaya,
                    'id_setup_biaya'      => $request->id_setup_biaya,
                    'discount'            => $request->discount,
                    'is_percentage'       => $percentage,
                ]);
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = DiscountBiaya::where('id',$id)->delete();     
        return response()->json($post);
    }
}
