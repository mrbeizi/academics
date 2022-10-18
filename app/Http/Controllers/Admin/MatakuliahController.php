<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Matakuliah;

class MatakuliahController extends Controller
{
    public function index(Request $request)
    {
        return view('administrator.matakuliah.index');
    }
}
