<?php

namespace App\Http\Controllers\Keuangan;

// For Import
use App\Imports\Keuangan\ImportPayment;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\PaymentList;
use App\Model\Keuangan\Payment;
use App\Model\Mahasiswa;
use Carbon\Carbon;
use PDF;
use Response;
use Session;
use Validator;
use Auth;
use DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $dataMahasiswa = Mahasiswa::leftJoin('prodis','prodis.id','=','mahasiswas.id_prodi')
            ->leftJoin('status_mahasiswas','status_mahasiswas.id','=','mahasiswas.id_status_mahasiswa')
            ->select('mahasiswas.id AS id','mahasiswas.*','prodis.nama_id AS nama_prodi','status_mahasiswas.id AS ism','status_mahasiswas.nama_status')
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataMahasiswa)
                ->addColumn('action', function($data){
                    return '<a href="'.Route('view-rincian-payment',['id' => $data->nim]).'"><button type="button" name="view_form" id="'.$data->nim_mahasiswa.'" class="view_form btn btn-warning btn-xs" data-toggle="tooltip" data-placement="bottom" title="View Detail Payments"><i class="bx bx-xs bx-detail"></i> Payment</button></a>';
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
            'id_periode'         => 'required',
            'tgl_pembayaran'     => 'required',
            'keterangan'         => 'required',
        ],[
            'nim_mahasiswa.required'    => 'Anda belum memilih mahasiswa',
            'jumlah_bayar.required'     => 'Anda belum menginput jumlah bayar',
            'id_payment_list.required'  => 'Anda belum memilih nama pembayaran',
            'id_periode.required'       => 'Anda belum memilih periode',
            'tgl_pembayaran.required'   => 'Anda belum memilih tanggal pembayaran',
            'keterangan.required'       => 'Anda belum menginput keterangan'
        ]);

        $post   =   Payment::updateOrCreate(['id' => $request->id],
                    [
                        'nim_mahasiswa'     => $request->nim_mahasiswa,
                        'id_payment_list'   => $request->id_payment_list,
                        'jumlah_bayar'      => preg_replace('/\D/','', $request->jumlah_bayar),
                        'id_periode'        => $request->id_periode,
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
            $angkatan = $request->tanggal_masuk;
            
            $dataPayment = Payment::leftJoin('mahasiswas','mahasiswas.nim','=','payments.nim_mahasiswa')
                ->leftJoin('prodis','prodis.id','=','mahasiswas.id_prodi')
                ->leftJoin('payment_lists','payment_lists.id','=','payments.id_payment_list')
                ->select('payments.id AS id','payments.*','mahasiswas.nim','mahasiswas.nama_mahasiswa','prodis.kode_prodi','payment_lists.id AS id_pembayaran','payment_lists.nama_pembayaran')
                ->where('mahasiswas.tanggal_masuk','LIKE','%'.$request->tanggal_masuk.'%')
                ->whereBetween('payments.tgl_pembayaran',[$start_date,$end_date])
                ->orderBy('payments.nim_mahasiswa','ASC')
                ->get();

            $query = DB::table('payments')->leftJoin('mahasiswas','mahasiswas.nim','=','payments.nim_mahasiswa')
                ->leftJoin('prodis','prodis.id','=','mahasiswas.id_prodi')
                ->select('prodis.kode_prodi',DB::raw('SUM(payments.jumlah_bayar) AS total_denda'))
                ->where([['payments.id_payment_list', '=', 7],['mahasiswas.tanggal_masuk','LIKE','%'.$request->tanggal_masuk.'%']])
                ->whereBetween('payments.tgl_pembayaran',[$start_date,$end_date])
                ->groupBy('prodis.kode_prodi')
                ->get();

            $dataDenda = array();
            foreach($query as $row){
                $dataDenda[$row->kode_prodi][] = $row;
            }
        } else {
            $data = Payment::latest()->get();
        }

        $fileName = 'laporan_rekapitulasi_biaya_kuliah_'.date('Y-m-d').'.pdf';

        $pdf = PDF::loadView('keuangan.payment.report', compact('dataPayment','dataDenda','start_date','end_date','angkatan'));
        $pdf->setPaper('A4', 'landscape');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        // Get height and width of page 
        $w = $canvas->get_width(); 
        $h = $canvas->get_height(); 

        return $pdf->stream($fileName);
    }

    public function importPayment(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx',
        ],[
            'file.required'   => 'Anda belum memilih berkas excel',
            'file.mimes'      => 'Format berkas .csv, .xls, .xlsx'
        ]);

        $file = $request->file('file');
        $nama_file = date('Y-m-d_H-i-s').$file->getClientOriginalName();
        $file->move('import/file-keuangan',$nama_file);
        Excel::import(new ImportPayment, public_path('/import/file-keuangan/'.$nama_file));
        return redirect()->route('payment.index');
    }

    public function countFine(Request $request)
    {
        if($request->tanggal_awal <= $request->tanggal_akhir){
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $interval = Carbon::parse($tanggal_akhir)->diffInDays(Carbon::parse($tanggal_awal)) + 1;
            $total = 0;

            for($i=1; $i<=$interval; $i++){
                // $fine = ceil($i/7)*5000;
                // $total = $total + $fine;
                // New Calculation -- total equals to interval multiply to fine amount (5000) plus flat amount from the first week!
                $flatAmount = 5000;
                $finePerDay = 5000;
                $total = $flatAmount + ($interval*$finePerDay);
            }

            $content = '<div class="col-md">
                            <div class="card text-white bg-primary">
                            <div class="card-header">Hasil Perhitungan</div>
                            <div class="card-body">
                                <p class="card-title text-white">Dari tanggal '.tanggal_indonesia($tanggal_awal).' sampai dengan tanggal '.tanggal_indonesia($tanggal_akhir).' adalah '.$interval.' hari</p>
                                <h5 class="card-text">
                                Maka, total denda sebesar <b>'.currency_IDR($total).'</b>
                                </h5>
                            </div>
                            </div>
                        </div>';
        } else {
            $content = '<div class="col-md">
                            <div class="card text-white bg-primary">
                            <div class="card-header">Hasil Perhitungan</div>
                            <div class="card-body">
                                <p class="card-title text-white">Maaf, tanggal yang anda inputkan salah</p>
                                <h5 class="card-text">
                                Silahkan pilih tanggal dengan benar.</b>
                                </h5>
                            </div>
                            </div>
                        </div>';
        }

        return response()->json(['content' => $content]);
    }
}
