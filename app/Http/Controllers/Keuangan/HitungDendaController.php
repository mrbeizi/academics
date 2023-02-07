<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use Session;
use Validator;
use Auth;

class HitungDendaController extends Controller
{
    public function index(Request $request)
    {
        return view('keuangan.hitung-denda.index');
    }

    public function countFine(Request $request)
    {
        if($request->start_date <= $request->end_date){
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $interval = Carbon::parse($end_date)->diffInDays(Carbon::parse($start_date));
            $total = 0;

            for($i=1; $i<=$interval; $i++){
                $fine = ceil($i/7)*5000;
                $total = $total + $fine;
            }

            $content = '<div class="col-md">
                            <div class="card text-white bg-primary">
                            <div class="card-header">Hasil Perhitungan</div>
                            <div class="card-body">
                                <p class="card-title text-white">Dari tanggal '.tanggal_indonesia($start_date).' sampai dengan tanggal '.tanggal_indonesia($end_date).' adalah '.$interval.' hari</p>
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
