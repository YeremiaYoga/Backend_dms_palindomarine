<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Revisi;
use App\Models\Uploader;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RevisiController extends Controller
{
    public function indexdetail($id){
        $data = DB::table('revisis')
                ->select("revisis.id",
                "projeks.nama_projek",
                "projeks.projek_id",
                "uploaders.judul",
                "uploaders.drawing_number",
                "uploaders.status")
                ->rightJoin('uploaders', 'uploaders.id', '=', 'revisis.id_uploaders')
                ->join('projeks', 'projeks.id', '=', 'uploaders.id_projeks')
                ->where('uploaders.id', '=', $id)
                ->orderByDesc('revisis.created_at')
                ->get();

                if(count($data) > 0){
                    return response([
                        'message' => 'Berhasil',
                        'data' => $data
                    ],200);
                }
        
                return response([
                    'message' => 'Tidak ada',
                    'data' => null
                ], 400);
    }
    public function indexchecker($id){
        $data = DB::table('revisis')
                ->select("revisis.id",
                "users.nama",)
                ->rightJoin('uploaders','uploaders.id', '=', 'revisis.id_uploaders')
                ->join('users','users.id', '=', 'uploaders.id_checker')
                ->where('uploaders.id','=', $id)
                ->get();

                if(count($data) > 0){
                    return response([
                        'message' => 'Berhasil',
                        'data' => $data
                    ],200);
                }
                
        
                return response([
                    'message' => 'Tidak ada',
                    'data' => null
                ], 400);
    }
    public function indexdrafter($id){
        $data = DB::table('revisis')
                ->select("revisis.id",
                "users.nama",
                "users.divisi")
                ->rightJoin('uploaders','uploaders.id', '=', 'revisis.id_uploaders')
                ->join('users','users.id', '=', 'uploaders.id_drafter')
                ->where('uploaders.id','=', $id)
                ->get();

                if(count($data) > 0){
                    return response([
                        'message' => 'Berhasil',
                        'data' => $data
                    ],200);
                }
        
                return response([
                    'message' => 'Tidak ada',
                    'data' => null
                ], 400);
    }
    public function tampil($id)
    {
        $revisi =  Revisi::where('id_uploaders',$id)
        ->where('hapus','=', 1)->get();

        if(!is_null($revisi)){
            return response([
                'message' => 'Berhasil',
                'data' => $revisi
            ],200);
        }
    }
    public function index()
    {
        $revisi = Revisi::all();
        if(count($revisi) > 0){
            return response([
                'message' => 'Berhasil',
                'data' => $revisi
            ],200);
        }

        return response([
            'message' => 'Tidak ada',
            'data' => null
        ], 400);
    }
    public function getchecker(Request $request ,$id){
        $inputdata = $request->all();
        $uploader = Uploader::find($id);
        $uploader->id_checker = $inputdata['user_id'];
        $uploader->status = "Checking";
        $uploader->save();
    }
    
    
    public function tambah(Request $request, $id)
    {
        $inputdata = $request->all();
        $validate = Validator::make($inputdata,[

        'nama_revisi' => 'required',
        'tipe_revisi' => 'required',
        'status_revisi' => '',
        
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()],400);
        }
        $revisi = Revisi::create($inputdata);
        $uploader = Uploader::find($id);
        $guests = $uploader->rev + 1;
        $uploader->rev = $guests;
        $uploader->status = "Revisi";
        $uploader->save();
        return response([

            'message' => 'Tambah Revisi Berhasil',
            'data' => $revisi,
            
        ],200);
    }

    public function hapus($id)
    {
        $revisi = Revisi::find($id);

        if(is_null($revisi)){
            return response([
                'message' => 'revisi tidak ditemukan',
                'data' => null
            ],404);
        }

        $revisi->hapus = 0;
        if($revisi->save()){
            return response([
                'message' => 'Hapus revisi Berhasil',
                'data' => $revisi,
            ],200);
        };
    }
    public function update(Request $request, $id)
    {
        $revisi = Revisi::find($id);
        if(is_null($revisi)){
            return response([
                'message' => 'revisi tidak ditemukan',
                'data' => null
            ], 404);
        }

        $updatedata = $request->all();
        $validate = Validator::make($updatedata, [
            'nama_revisi' => '',
            'tipe_revisi' => '',
            'status_revisi' => '',
        ]);

        if($validate->fails()){
            return response(['message' => $validate->errors()],400);
        }

        $revisi->nama_revisi = $updatedata['nama_revisi'];
        $revisi->tipe_revisi = $updatedata['tipe_revisi'];   
        $revisi->status_revisi = $updatedata['status_revisi'];
        
        if($revisi->save()){
            return response([
                'message' => 'Update revisi Berhasil',
                'data' => $revisi,
            ],200);
        }

        return response([
            'message' => 'Update revisi Gagal',
            'data' => null
        ],400);
    }
    
    public function confirmRevisi($id){
        $revisi = Revisi::find($id);
        $revisi->status_revisi = "Cleared";
        $revisi->save();
        return response([
            'message' => 'Confirm revisi Berhasil',
            'data' => $revisi,
        ],200);
    }
}
