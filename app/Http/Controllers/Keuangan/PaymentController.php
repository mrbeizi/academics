<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\PaymentList;
use App\Model\Keuangan\Payment;
use App\Model\Keuangan\Semester;
use App\Model\Mahasiswa;
use Carbon\Carbon;
use PDF;
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

    public function print(Request $request)
    {
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            
            $data = Payment::leftJoin('mahasiswas','mahasiswas.nim','=','payments.nim_mahasiswa')
                ->leftJoin('prodis','prodis.id','=','mahasiswas.id_prodi')
                ->leftJoin('payment_lists','payment_lists.id','=','payments.id_payment_list')
                ->select('payments.id AS id','payments.*','mahasiswas.nim','mahasiswas.nama_mahasiswa','prodis.kode_prodi','payment_lists.nama_pembayaran')
                ->whereBetween('payments.tgl_pembayaran',[$start_date,$end_date])
                ->orderBy('payments.nim_mahasiswa','ASC')
                ->get();
        } else {
            $data = Payment::latest()->get();
        }

        $pdf = PDF::loadView('keuangan.payment.report', compact('data','start_date','end_date'));
        $pdf->setPaper('A4', 'landscape');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        // Get height and width of page 
        $w = $canvas->get_width(); 
        $h = $canvas->get_height(); 

        return $pdf->stream('contoh.pdf');
    }
}
