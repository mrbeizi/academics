<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\Payment;
use App\Model\Keuangan\PaymentList;
use App\Model\Keuangan\PaymentDiscount;
use App\Model\Keuangan\SetupBiaya;
use App\Model\Keuangan\BiayaKuliah;
use App\Model\Mahasiswa;
use App\Model\Periode;
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
            ->leftJoin('periodes','periodes.id','=','payments.id_periode')
            ->leftJoin('payment_discounts','payment_discounts.id_data_payment','=','payments.id')
            ->select('payments.id AS id','payments.*','mahasiswas.nim','mahasiswas.nama_mahasiswa','mahasiswas.id_status_mahasiswa','prodis.nama_id','payment_lists.nama_pembayaran','payment_discounts.jumlah_potongan','periodes.nama_periode','periodes.kode')
            ->where([['payments.nim_mahasiswa',$id],['periodes.is_active','=',1]])
            ->orderBy('payments.created_at','DESC')
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataPayments)
                ->addColumn('action', function($data){
                    if($data->id_status_mahasiswa <= 3) {
                        $button = '<button type="button" name="add-potongan" data-id="'.$data->id.'" class="add-potongan btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="Update Potongan"><i class="bx bx-xs bx-dollar-circle"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Edit" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                    } else {
                        return '<span class="badge bg-label-secondary me-1">Disabled</span>';
                    }
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getBiaya = BiayaKuliah::leftJoin('mahasiswas','mahasiswas.nim','=','biaya_kuliahs.nim')
            ->leftJoin('status_mahasiswas','status_mahasiswas.id','=','mahasiswas.id_status_mahasiswa')
            ->leftJoin('periodes','periodes.id','=','biaya_kuliahs.id_periode')
            ->select('biaya_kuliahs.id AS id','biaya_kuliahs.*','status_mahasiswas.id AS ism','status_mahasiswas.nama_status')
            ->where([['mahasiswas.nim','=',$id],['periodes.is_active','=',1]])
            ->get();
        $sumBiaya = BiayaKuliah::leftJoin('periodes','periodes.id','=','biaya_kuliahs.id_periode')->where([['nim','=',$id],['periodes.is_active','=',1]])->sum('biaya_kuliahs.biaya');
        $grandTotal = Payment::where('nim_mahasiswa',$id)->sum('jumlah_bayar');

        // Check State of students
        if($this->studentState($id)->id_status_mahasiswa == 3){
            $getPaymentList = PaymentList::select('id','nama_pembayaran')->where('id','=',3)->get();
        } else {
            $getPaymentList = PaymentList::select('id','nama_pembayaran')->where('id','!=', 3)->get();
        }

        $getPeriode = Periode::select('id','kode','nama_periode')->where('is_active',1)->get();
        return view('keuangan.view-rincian.v-rincian-payment', ['id' => $id,'getPaymentList' => $getPaymentList,'getPeriode'=>$getPeriode,'getBiaya' => $getBiaya,'grandTotal'=>$grandTotal,'studentState' => $this->studentState($id),'sumBiaya' => $sumBiaya]);
    }

    protected function studentState($nim)
    {
        $data = Mahasiswa::where('nim',$nim)->select('id_status_mahasiswa')->first();
        return $data;
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
            'id_periode.required'       => 'Anda belum memilih Periode',
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
