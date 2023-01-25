<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Uploader;
use App\Models\Revisi;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DokumenController extends Controller
{

    public function downloadUploader($id) {

        $dokumen = Dokumen::where('id_uploaders', $id)
        ->where('status_dokumen', '=' , 1)->get();
        \Log::debug($dokumen);
        
        if(!is_null($dokumen)) {
            
            return response([
                'message' => 'Berhasil',
                'data' => $dokumen
            ], 200);
        }
        return response([
            'message' => 'Belum Dikonfirmasi',
            'data' => null
        ], 404);
    }
    public function downloadRevisi($id) {

        $dokumen = Dokumen::where('id_revisis', $id)
        ->where('status_dokumen', '=' , 1)->get();
        \Log::debug($dokumen);
        
        if(!is_null($dokumen)) {
            
            return response([
                'message' => 'Berhasil',
                'data' => $dokumen
            ], 200);
        }
        return response([
            'message' => 'Belum Dikonfirmasi',
            'data' => null
        ], 404);
    }
    public function downloadRevisiChecker($id) {

        $dokumen = Dokumen::where('id_revisis', $id)
        ->where('status_dokumen', '=' , 1)->get();
        \Log::debug($dokumen);
        
        if(!is_null($dokumen)) {
            $revisi = Revisi::find($id);
            $revisi->status_revisi = "Checking";
            $revisi->save();
            return response([
                'message' => 'Berhasil',
                'data' => $dokumen
            ], 200);
        }
        return response([
            'message' => 'Belum Dikonfirmasi',
            'data' => null
        ], 404);
    }
    public function index()
    {
        $dokumen = Dokumen::all();
        if(count($dokumen) > 0){
            return response([
                'message' => 'Berhasil',
                'data' => $dokumen
            ],200);
        }

        return response([
            'message' => 'Tidak ada',
            'data' => null
        ], 400);
    }
    
    public function indexdokumen($id)
    {
        $dokumen = Dokumen::find($id);
        if(count($dokumen) > 0){
            return response([
                'message' => 'Berhasil',
                'data' => $dokumen
            ],200);
        }

        return response([
            'message' => 'Tidak ada',
            'data' => null
        ], 400);
    }
    public function tampilrevisi($id_revisis){
        $dokumen =  Dokumen::where('id_revisis',$id_revisis)
        ->where('status_dokumen', '=', 1)->get();

        if(!is_null($dokumen)){
            return response([
                'message' => 'Berhasil',
                'data' => $dokumen
            ],200);
        }
    }
    public function tampilkonfirmasi(){
        $dokumen =  Dokumen::where('status_dokumen','=', 0)->get();

        if(!is_null($dokumen)){
            return response([
                'message' => 'Berhasil',
                'data' => $dokumen
            ],200);
        }
    }

    public function indexkonfirm($id)
    {
        $data = DB::table('dokuments')
                ->select("dokuments.id",
                "dokuments.dokumen",
                "projeks.projek_id",
                "projeks.nama_projek",
                "uploaders.judul",
                "uploaders.drawing_number")
                ->join('uploaders', 'uploaders.id', '=', 'dokuments.id_uploaders')
                ->join('projeks', 'projeks.id', '=', 'uploaders.id_projeks')
                ->where('status_dokumen', '=' , 0)
                ->orderByDesc('dokuments.created_at')
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
    public function confirmdocument(Request $request, $id){
        $dokumen = Dokumen::findOrFail($id);
        if(is_null($dokumen)){
            return response([
                'message' => 'Dokumen tidak ditemukan',
                'data' => null
            ], 404);
        }

        $updatedata = $request->all();
        $validate = Validator::make($updatedata, [
            'status_dokumen' => 'required',
            
        ]);

        if($validate->fails()){
            return response(['message' => $validate->errors()],400);
        }

        $dokumen->status_dokumen = $updatedata['status_dokumen'];

        if($dokumen->save()){
            return response([
                'message' => 'Konfirmasi Berhasil',
                'data' => $dokumen,
            ],200);
        }

        return response([
            'message' => 'Konfirmasi Gagal',
            'data' => null
        ],400);
    }

    public function tambah(Request $request, $id){
        $inputdata = $request->all();
        $validate = Validator::make($inputdata,[

            'id_uploaders' => 'required',
            'id_users' => 'required',
            'dokumen' => 'required',
            'url_dokumen' => 'required',
            'hapus' => 'required',
            'status_dokumen' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()],400);
        }
        
        $dokumen = Dokumen::create($inputdata);
        $inputdata = $request->all();
        $uploader = Uploader::find($id);
        $uploader->id_drafter = $inputdata['id_users'];
        $uploader->status = "Waiting";

        $uploader->save();
        return response([
            'message' => 'Tambah dokumen Berhasil',
            'data' => $dokumen,
        ],200);
    }
    public function revisi(Request $request, $id){
        $inputdata = $request->all();
        $validate = Validator::make($inputdata,[

            'id_uploaders' => '',
            'id_revisis' => '',
            'id_users' => '',
            'dokumen' => '',
            'url_dokumen' => '',
            'hapus' => 'required',
            'status_dokumen' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()],400);
        }
        $dokumen = Dokumen::create($inputdata);
        $inputdata = $request->all();
        $revisi = Revisi::find($id);
        $revisi->status_revisi = "Waiting";

        $revisi->save();
        return response([
            'message' => 'Tambah revisi Berhasil',
            'data' => $dokumen,
        ],200);
    }

    public function hapus($id){
        $dokumen = Dokumen::find($id);

        if(is_null($dokumen)){
            return response([
                'message' => 'dokument tidak ditemukan',
                'data' => null
            ],404);
        }

        
        if($dokumen->delete()){
            return response([
                'message' => 'Hapus dokument Berhasil',
                'data' => $dokumen,
            ],200);
        }
    }
}
