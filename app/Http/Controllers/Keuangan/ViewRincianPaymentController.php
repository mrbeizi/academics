<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\Payment;
use App\Model\Keuangan\PaymentList;
use App\Model\Keuangan\PaymentDiscount;
use App\Model\Keuangan\Semester;
use App\Model\Mahasiswa;
use Response;
use Session;
use Validator;
use Auth;

class ViewRincianPaymentController extends Controller
{
    public function index(Request $request, $id)
    {
        $dataPayments = Payment::leftJoin('mahasiswas','mahasiswas.nim','=','payments.nim_mahasiswa')
            ->leftJoin('prodis','prodis.id','=','mahasiswas.id_prodi')
            ->leftJoin('payment_lists','payment_lists.id','=','payments.id_payment_list')
            ->leftJoin('payment_discounts','payment_discounts.id_data_payment','=','payments.id')
            ->select('payments.id AS id','payments.*','mahasiswas.nim','mahasiswas.nama_mahasiswa','prodis.nama_id','payment_lists.nama_pembayaran','payment_discounts.jumlah_potongan')
            ->where('payments.nim_mahasiswa',$id)
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataPayments)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="add-potongan" data-id="'.$data->id.'" class="add-potongan btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="Update Potongan"><i class="bx bx-xs bx-dollar-circle"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Edit" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getPaymentList = PaymentList::select('id','nama_pembayaran')->get();
        $getSemester = Semester::select('id','nama_semester')->get();
        return view('keuangan.view-rincian.v-rincian-payment', ['id' => $id,'getPaymentList' => $getPaymentList,'getSemester'=>$getSemester]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim_mahasiswa'      => 'required',
            'jumlah_bayar'       => 'required',
            'id_payment_list'    => 'required',
            'semester'           => 'required',
            'tgl_pembayaran'     => 'required',
            'keterangan'         => 'required',
        ],[
            'nim_mahasiswa.required'    => 'Anda belum memilih mahasiswa',
            'jumlah_bayar.required'     => 'Anda belum menginput jumlah bayar',
            'id_payment_list.required'  => 'Anda belum memilih nama pembayaran',
            'semester.required'         => 'Anda belum memilih Semester',
            'tgl_pembayaran.required'   => 'Anda belum memilih tanggal pembayaran',
            'keterangan.required'       => 'Anda belum menginput keterangan'
        ]);

        $post   =   Payment::updateOrCreate(['id' => $request->id],
                    [
                        'nim_mahasiswa'     => $request->nim_mahasiswa,
                        'id_payment_list'   => $request->id_payment_list,
                        'jumlah_bayar'      => preg_replace('/\D/','', $request->jumlah_bayar),
                        'semester'          => $request->semester,
                        'tgl_pembayaran'    => $request->tgl_pembayaran,
                        'keterangan'        => $request->keterangan,
                    ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Payment::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Payment::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function addPotongan(Request $request)
    {
        $request->validate([
            'jumlah_potongan'  => 'required',
        ],[
            'jumlah_potongan.required'  => 'Anda belum menginputkan jumlah potongan'
        ]);

        $percentage = $request->input('percentage');
        if($percentage == null) { $percentage = $request->input('percentage') ?? 0; } 
        else { $percentage = $request->input('percentage') ?? 1; }

        $post   =   PaymentDiscount::updateOrCreate(['id' => $request->id],
                    [
                        'id_data_payment'   => $request->id_data_payment,
                        'jumlah_potongan'   => preg_replace('/\D/','', $request->jumlah_potongan),
                        'is_percentage'     => $percentage,
                        'keterangan'        => $request->keterangan,
                    ]); 
        return response()->json($post);
    }
}
