<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $dataUser = User::all();
                
        if($request->ajax()){
            return datatables()->of($dataUser)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="fa fa-pen"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('administrator.user.index');
    }

    public function store(Request $request)
    {
        $request->validate(
            ['name' => 'required',],
            ['name.required' => 'Anda belum menginputkan tahun',]
        );

        $post = User::updateOrCreate(['id' => $request->id],
                [
                    'name'       => $request->name,
                    'email'   => $request->email,
                    'password' => Hash::make($request['password']),
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = User::where($where)->first();     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = User::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function profile()
    {
        return view('administrator.user.profile');
    }

    public function getPass()
    {
        return redirect()->route('change-password');
    }

    public function postPass(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        // return redirect()->route('profile')->with('success','Password has changed successfully!');
        return redirect()->back()->with('success', 'Created successfully!');
    }
}
