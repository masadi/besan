<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yayasan;
use App\Models\Santri;
use App\Models\Jenis_pembiayaan;

class ReferensiController extends Controller
{
    public function index(Request $request, $query){
        $function = 'get_'.str_replace('-', '_', $query);
        return $this->{$function}($request);
    }
    public function get_yayasan($request){
        $user = $request->user();
        if ($request->isMethod('post')) {
            if($request->yayasan_id){
                $yayasan = Yayasan::find($request->yayasan_id);
                $yayasan->nama = $request->nama;
                $yayasan->alamat = $request->alamat;
                $yayasan->ketua = $request->ketua;
                $yayasan->pendamping = $request->pendamping;
                $yayasan->bendahara = $request->bendahara;
                $yayasan->save();
            } else {
                $yayasan = Yayasan::create([
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'ketua' => $request->ketua,
                    'pendamping' => $request->pendamping,
                    'bendahara' => $request->bendahara,
                ]);
            }
            if($yayasan){
                $user->yayasan_id = $yayasan->id;
                $user->save();
                $response = ['status' => 'success', 'message' => 'Data yayasan berhasil disimpan'];
            } else {
                $response = ['status' => 'failed', 'message' => 'Data yayasan gagal disimpan'];
            }
            return response()->json($response);
        }
        $yayasan = Yayasan::find($user->yayasan_id);
        return response()->json(['status' => 'success', 'data' => $yayasan]);
    }
    public function get_santri($request){
        $user = $request->user();
        $data = Santri::where('yayasan_id', $user->yayasan_id)->orderBy(request()->sortby, request()->sortbydesc)
            //JIKA Q ATAU PARAMETER PENCARIAN INI TIDAK KOSONG
            ->when(request()->q, function($data) {
                //MAKA FUNGSI FILTER AKAN DIJALANKAN
                $data = $data->where('nama', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('tempat_lahir', 'LIKE', '%' . request()->q . '%');
        })->paginate(request()->per_page); //KEMUDIAN LOAD PAGINATIONNYA BERDASARKAN LOAD PER_PAGE YANG DIINGINKAN OLEH USER
        return response()->json(['status' => 'success', 'data' => $data]);
        $yayasan = Santri::where('yayasan_id', $user->yayasan_id)->get();
        return response()->json(['status' => 'success', 'data' => $yayasan]);
    }
    public function get_pembiayaan($request){
        $user = $request->user();
        $yayasan = Jenis_pembiayaan::where('yayasan_id', $user->yayasan_id)->get();
        return response()->json(['status' => 'success', 'data' => $yayasan]);
    }
}
