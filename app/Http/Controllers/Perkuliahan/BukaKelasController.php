<?php

namespace App\Http\Controllers\Perkuliahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Perkuliahan\StatusKelasKuliah;
use App\Model\Matakuliah;
use App\Model\Periode;
use App\Model\Prodi;
use Response;
use Session;
use Validator;
use Auth;

class BukaKelasController extends Controller
{
    public function index(Request $request)
    {
        $getPeriode = Periode::all();
        $getStatusKelas = StatusKelasKuliah::all();
        $getProdi = Prodi::all();
        $getMatakuliah = Matakuliah::all();
        return view('perkuliahan.buka-kelas.index', compact('getPeriode','getStatusKelas','getProdi','getMatakuliah'));
    }
}
