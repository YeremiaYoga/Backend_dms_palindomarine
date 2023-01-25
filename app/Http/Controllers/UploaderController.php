<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uploader;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UploaderController extends Controller
{
    public function index()
    {
        $uploader = Uploader::where('hapus','=', 1)->get();
        if(count($uploader) > 0){
            return response([
                'message' => 'Berhasil',
                'data' => $uploader
            ],200);
        }

        return response([
            'message' => 'Tidak ada',
            'data' => null
        ], 400);
    }

    public function tampil($id_projeks)
    {
        $uploader =  Uploader::where('id_projeks',$id_projeks)
        ->where('hapus','=', 1)->get();

        if(!is_null($uploader)){
            return response([
                'message' => 'Berhasil',
                'data' => $uploader
            ],200);
        }
    }

    public function tambah(Request $request)
    {
        $inputdata = $request->all();
        $validate = Validator::make($inputdata,[

            'judul' => 'required',
            'drawing_number' => 'required',
            'status' => '',
            'rev' => 'required',
            
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()],400);
        }
        $uploader = Uploader::create($inputdata);
        return response([
            'message' => 'Tambah uploader Berhasil',
            'data' => $uploader,
        ],200);
    }

    public function hapus($id)
    {
        $uploader = Uploader::find($id);

        if(is_null($uploader)){
            return response([
                'message' => 'uploader tidak ditemukan',
                'data' => null
            ],404);
        }

        $uploader->hapus = 0;
        if($uploader->save()){
            return response([
                'message' => 'Hapus uploader Berhasil',
                'data' => $uploader,
            ],200);
        };
    }

    public function update(Request $request, $id)
    {
        $uploader = Uploader::find($id);
        if(is_null($uploader)){
            return response([
                'message' => 'uploader tidak ditemukan',
                'data' => null
            ], 404);
        }

        $updatedata = $request->all();
        $validate = Validator::make($updatedata, [
            'judul' => '',
            'drawing_number' => '',
            'status' => '',
            'rev' => '',
        ]);

        if($validate->fails()){
            return response(['message' => $validate->errors()],400);
        }

        $uploader->judul = $updatedata['judul'];
        $uploader->drawing_number = $updatedata['drawing_number'];   
        $uploader->status = $updatedata['status'];
        $uploader->rev = $updatedata['rev'];
        
        if($uploader->save()){
            return response([
                'message' => 'Update uploader Berhasil',
                'data' => $uploader,
            ],200);
        }

        return response([
            'message' => 'Update uploader Gagal',
            'data' => null
        ],400);
    }
    public function confirmDocument($id){
        $uploader = Uploader::find($id);
        $uploader->status = "Cleared";
        $uploader->save();
        return response([
            'message' => 'Confirm Document Berhasil',
            'data' => $uploader
        ],200);
    }
    // public function updateStatus(Request $request, $id){
    //     $uploader = Uploader::find($id);
    //     if(is_null($uploader)){
    //         return response([
    //             'message' => 'uploader tidak ditemukan',
    //             'data' => null
    //         ], 404);
    //     }

    //     $updatedata = $request->all();
    //     $validate = Validator::make($updatedata, [
    //         'status' => '',
    //     ]);

    //     if($validate->fails()){
    //         return response(['message' => $validate->errors()],400);
    //     }
        

    //     $user = Auth::id();

    //     \Log::debug($user);

    //     if($uploader->status != $updatedata['status']) {
    //         DB::table('history_actions')->insert([
    //             'id_uploaders' => $id,
    //             'id_users' => $user,
    //             'actions' => 5
    //         ]);
    //     }

    //     $uploader->status = $updatedata['status'];
    
    //     if($uploader->save()){
    //         return response([
    //             'message' => 'Update uploader Berhasil',
    //             'data' => $uploader,
    //         ],200);
    //     }

    //     return response([
    //         'message' => 'Update uploader Gagal',
    //         'data' => null
    //     ],400);
    // }
}
