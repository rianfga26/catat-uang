<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keuangan;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function pengeluaran(Request $request){
        $request->validate([
            'kategori' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required|max:1000'
        ]);
        
        $arr = array();
        $tgl = explode('/',$request->tgl);
        // dd($tgl[2]);
        array_push($arr, $tgl[2]);
        array_push($arr, $tgl[0]);
        array_push($arr, $tgl[1]);
        
        

        $keuangan = new Keuangan;
        $keuangan->user_id = Auth::user()->id;
        $keuangan->kategori_id = $request->kategori;
        $keuangan->pemasukan = 0;
        $keuangan->pengeluaran = (int)implode('',explode(',',$request->jumlah));
        $keuangan->keterangan = $request->keterangan;
        $keuangan->created_at = implode('-', $arr);
        $keuangan->save();

        return redirect()->route('home');

    }
    public function pemasukan(Request $request){
        $request->validate([
            'kategori' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required|max:1000'
        ]);

        $arr = array();
        $tgl = explode('/',$request->tgl);
        // dd($tgl[2]);
        array_push($arr, $tgl[2]);
        array_push($arr, $tgl[0]);
        array_push($arr, $tgl[1]);
        
        
        
        $keuangan = new Keuangan;
        $keuangan->user_id = Auth::user()->id;
        $keuangan->kategori_id = $request->kategori;
        $keuangan->pemasukan = (int)implode('',explode(',',$request->jumlah));
        $keuangan->pengeluaran = 0;
        $keuangan->keterangan = $request->keterangan;
        $keuangan->created_at = implode('-', $arr);
        $keuangan->save();

        return redirect()->route('home');

    }
}
