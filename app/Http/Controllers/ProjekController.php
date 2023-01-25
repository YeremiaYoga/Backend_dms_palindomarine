<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projek;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ProjekController extends Controller
{
    public function index()
    {
        $projek = Projek::all();
        if(count($projek) > 0){
            return response([
                'message' => 'Berhasil',
                'data' => $projek
            ],200);
        }

        return response([
            'message' => 'Tidak ada',
            'data' => null
        ], 400);
    }

    public function tampil(){
        $projek =  Projek::where('hapus', 1)->get();
        
        if(!is_null($projek)){
            return response([
                'message' => 'Berhasil',
                'data' => $projek
            ],200);
        }
        return response([
            'message' => 'Projek tidak ada',
            'data' => null
        ], 404);
    }

    public function tambah(Request $request){
        $inputdata = $request->all();
        $validate = Validator::make($inputdata,[
            'nama_projek' => 'required',
            'projek_tipe' => 'required',
            'hull_number' => 'required',
            'client' => 'required',
            
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()],400);
        }
        $last = Projek::orderBy('id', 'DESC')->limit(1)->get();
        if (count($last) > 0) {
            $last = $last[0];
            $inputdata['projek_id'] = str_pad($last->id+1,4,0,STR_PAD_LEFT);
        }
        else{
            $inputdata['projek_id'] = '0001';
        }
        
        if($inputdata['projek_tipe'] === 'New Construction'){
            $inputdata['projek_id'] = $inputdata['projek_id'].'N';
        }
        else if($inputdata['projek_tipe'] === 'Ship in service'){
            $inputdata['projek_id'] = $inputdata['projek_id'].'R';
        }
        $projek = Projek::create($inputdata);
        return response([
            'message' => 'Tambah Projek Berhasil',
            'data' => $projek,
        ],200);
    }

    public function hapus($id){
        $projek = Projek::find($id);

        if(is_null($projek)){
            return response([
                'message' => 'Projek tidak ditemukan',
                'data' => null
            ],404);
        }
        $projek->hapus = 0;
        if($projek->save()){
            return response([
                'message' => 'Hapus Projek Berhasil',
                'data' => $projek,
            ],200);
        };
    }

    public function update(Request $request, $id){
        $projek = Projek::find($id);
        if(is_null($projek)){
            return response([
                'message' => 'Projek tidak ditemukan',
                'data' => null
            ], 404);
        }

        $updatedata = $request->all();
        $validate = Validator::make($updatedata, [
            // 'projek_id' => '',
            'nama_projek' => '',
            'projek_tipe' => '',
            'hull_number' => '',
            'client' => '',
            
        ]);

        if($validate->fails()){
            return response(['message' => $validate->errors()],400);
        }
        // $projek->projek_id = 0;
        // $last = Projek::orderBy('id', 'DESC')->limit(1)->get();
        // if (count($last) > 0) {
        //     $last = $last[0];
        //     $updatedata['projek_id'] = str_pad($last->id+1,4,0,STR_PAD_LEFT);
        // }
        // else{
        //     $updatedata['projek_id'] = '0001';
        // }
        
        // if($updatedata['projek_tipe'] === 'New Construction'){
        //     $updatedata['projek_id'] = $updatedata['projek_id'].'N';
        // }
        // else if($updatedata['projek_tipe'] === 'Ship in service'){
        //     $updatedata['projek_id'] = $updatedata['projek_id'].'R';
        // }
        $projek->nama_projek = $updatedata['nama_projek'];
        $projek->projek_tipe = $updatedata['projek_tipe'];
        $projek->hull_number = $updatedata['hull_number'];
        $projek->client = $updatedata['client'];
        

        if($projek->save()){
            return response([
                'message' => 'Update Projek Berhasil',
                'data' => $projek,
            ],200);
        }

        return response([
            'message' => 'Update Projek Gagal',
            'data' => null
        ],400);
    }
    
}
