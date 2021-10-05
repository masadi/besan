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
