<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\MatakuliahKurikulum;

class MatakuliahKurikulumController extends Controller
{
    public function index(Request $request)
    {
        return view('administrator.mk-kurikulum.index');
    }
}
