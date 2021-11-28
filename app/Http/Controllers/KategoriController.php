<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request){
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required'
        ]);

        $kategori = new Kategori;
        $kategori->user_id = \Auth::user()->id;
        $kategori->nama = $request->nama;
        $kategori->jenis = $request->jenis;
        $kategori->save();

        return redirect()->back();
    }

    public function hapus($id)
    {   
        $del = Kategori::find($id);
        if($del != null){
            $del->delete();
            return redirect()->back();
        }
        return redirect()->back();
    }
}
