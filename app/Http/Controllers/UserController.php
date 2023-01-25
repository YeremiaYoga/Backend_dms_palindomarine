<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        if(count($user) > 0){
            return response([
                'message' => 'Berhasil',
                'data' => $user
            ],200);
        }

        return response([
            'message' => 'Tidak ada',
            'data' => null
        ], 400);
    }

    public function tampil(){
        $user =  User::all();

        if(!is_null($user)){
            return response([
                'message' => 'Berhasil',
                'data' => $user
            ],200);
        }
        return response([
            'message' => 'User tidak ada',
            'data' => null
        ], 404);
    }
    public function tampiluser($id){
        $user =  User::find($id);

        if(!is_null($user)){
            return response([
                'message' => 'Berhasil',
                'data' => $user
            ],200);
        }
        return response([
            'message' => 'User tidak ada',
            'data' => null
        ], 404);
    }

    public function tambah(Request $request){
        $inputdata = $request->all();
        $validate = Validator::make($inputdata,[

            'nama' => 'required',
            'no_telepon' => '',
            'role' => 'required',
            'divisi' => 'required',
            'email' => 'required',
            'password' => '',

        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()],400);
        }

        $inputdata['password'] = bcrypt($inputdata['password']);
        $user = User::create($inputdata);
        return response([
            'message' => 'Tambah User Berhasil',
            'data' => $user,
        ],200);
    }

    public function hapus($id){
        $user = User::find($id);
        if(is_null($user)){
            return response([
                'message' => 'User tidak ditemukan',
                'data' => null
            ],404);
        }

        if($user->delete()){
            return response([
                'message' => 'Hapus User Berhasil',
                'data' => $user,
            ],200);
        };
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        if(is_null($user)){
            return response([
                'message' => 'User tidak ditemukan',
                'data' => null
            ], 404);
        }

        $updatedata = $request->all();
        $validate = Validator::make($updatedata, [
            'nama' => [Rule::unique('users')->ignore($user)],
            'no_telepon' => '',
            'email' => [Rule::unique('users')->ignore($user)],
            'password' => '',
            'role' => '',
            'divisi' => '',
        ]);
        if($validate->fails()){
            return response(['message' => $validate->errors()],400);
        }
        $user->nama = $updatedata['nama'];
        $user->no_telepon = $updatedata['no_telepon'];
        $user->divisi = $updatedata['divisi'];
        $user->role = $updatedata['role'];
        $user->email = $updatedata['email'];
        $user->password = bcrypt($updatedata['password']);
        
        
        if($user->save()){
            return response([
                'message' => 'Update User Berhasil',
                'data' => $user,
            ],200);
        }

        return response([
            'message' => 'Update User Gagal',
            'data' => null
        ],400);
    }
}
