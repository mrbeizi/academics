<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\PaymentList;
use App\Model\Keuangan\Payment;
use App\Model\Keuangan\Semester;
use App\Model\Mahasiswa;
use Response;
use Session;
use Validator;
use Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $dataMahasiswa = Mahasiswa::leftJoin('prodis','prodis.id','=','mahasiswas.id_prodi')
            ->select('mahasiswas.id AS id','mahasiswas.*','prodis.nama_id AS nama_prodi')
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataMahasiswa)
                ->addColumn('action', function($data){
                    return '<a href="'.Route('view-rincian-payment',['id' => $data->nim]).'"><button type="button" name="view_form" id="'.$data->nim_mahasiswa.'" class="view_form btn btn-warning btn-xs" data-toggle="tooltip" data-placement="bottom" title="View Rincian"><i class="bx bx-xs bx-detail"></i> Detail</button></a>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('keuangan.payment.index');
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
}
