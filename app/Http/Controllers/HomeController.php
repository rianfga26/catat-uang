<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Kategori;
use App\Keuangan;
use Illuminate\Support\Facades\Auth;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('harian');
    }

    public function pdf(Request $request)
    {   
        
        $total_perbulan = Keuangan::query()
            ->whereMonth('created_at', (int) $request->bulan)
            ->whereYear('created_at', (int) $request->tahun)
            ->where('user_id', Auth::user()->id)
            ->selectRaw('YEAR(created_at) year, MONTH(created_at) month,sum(pemasukan) as total_pemasukan, sum(pengeluaran) as total_pengeluaran, (sum(pemasukan) - sum(pengeluaran)) as saldo')
            ->groupBy('year', 'month')
            ->get();

        $data_perbulan = Keuangan::query()
        ->whereMonth('created_at', (int) $request->bulan)
        ->whereYear('created_at', (int) $request->tahun)
        ->where('user_id', Auth::user()->id)
        ->with('kategori')
        ->get();

        if(empty($total_perbulan->toArray())){
            return redirect()->back()->with('alert', 'Tidak dapat mengunduh karena data tidak tersedia!');
        }
        $pdf = PDF::loadview('layouts.pdf-report', compact('data_perbulan', 'total_perbulan'))->setPaper('a4', 'potrait');
        return $pdf->download("laporan-keuangan-".\Carbon\Carbon::now()->format('d-m-Y').".pdf");
    }

    public function ajax_harian($month, $year)
    {
        $harian = Keuangan::query()
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('user_id', Auth::user()->id)
            ->groupBy('created_at')
            ->selectRaw('*, sum(pemasukan) as total_pemasukan, sum(pengeluaran) as total_pengeluaran')
            ->orderBy('created_at','desc')
            ->get();

        foreach ($harian as $key => &$hari) {
            $hari->keterangan = Keuangan::query()
                ->where('user_id', Auth::user()->id)
                ->with('kategori')
                ->where('created_at', $hari->created_at)
                ->get();

            $hari->total_perbulan = Keuangan::query()
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('user_id', Auth::user()->id)
                ->selectRaw('YEAR(created_at) year, MONTH(created_at) month,sum(pemasukan) as total_pemasukan, sum(pengeluaran) as total_pengeluaran, (sum(pemasukan) - sum(pengeluaran)) as saldo')
                ->groupBy('year', 'month')
                ->get();

            $hari->hari = \Carbon\Carbon::parse($hari->created_at)
                ->locale('id')->isoFormat('dddd');
            $hari->tgl = \Carbon\Carbon::parse($hari->created_at)
                ->locale('id')->isoFormat('LL');
        }
        return $harian;
    }


    public function bulanan()
    {
        return view('bulanan');
    }

    public function ajax_bulanan($month, $year)
    {

        $bulanan = Keuangan::query()
            ->whereYear('created_at', $year)
            ->where('user_id', Auth::user()->id)
            ->selectRaw('YEAR(created_at) year, MONTH(created_at) month, sum(pemasukan) as total_pemasukan, sum(pengeluaran) as total_pengeluaran')
            ->groupBy('year', 'month')
            ->orderBy('month', 'desc')
            ->get();

            foreach ($bulanan as $key => &$bulan) {
                $bulan->total_pertahun = Keuangan::query()
                    ->whereYear('created_at', $year)
                    ->where('user_id', Auth::user()->id)
                    ->selectRaw('YEAR(created_at) year, sum(pemasukan) as total_pemasukan, sum(pengeluaran) as total_pengeluaran, (sum(pemasukan) - sum(pengeluaran)) as saldo')
                    ->groupBy('year')
                    ->get();
            }

        $data = array(
            'bln' => $bulanan
        );

        return $data;
    }

    public function tahunan()
    {
        $tahunan = Keuangan::query()
            ->where('user_id', Auth::user()->id)
            ->selectRaw('YEAR(created_at) year, sum(pemasukan) as total_pemasukan,sum(pengeluaran) as total_pengeluaran')
            ->groupBy('year')
            ->get();
        if(empty($tahunan->toArray())){
            return view('tahunan');
        }else{
            foreach ($tahunan as $key => &$tahun) {
                $tahun->total = Keuangan::query()
                    ->where('user_id', Auth::user()->id)
                    ->selectRaw('sum(pemasukan) as total_pemasukan, sum(pengeluaran) as total_pengeluaran, (sum(pemasukan) - sum(pengeluaran)) as saldo')
                    ->get();
            }
        }

        return view('tahunan', compact('tahunan'));
    }
    public function pemasukan()
    {
        $kategori = Kategori::where('jenis', 'pemasukan')->where('user_id', Auth::user()->id)->get();
        return view('pemasukan', compact('kategori'));
    }

    public function pengeluaran()
    {
        $kategori = Kategori::where('jenis', 'pengeluaran')->where('user_id', Auth::user()->id)->get();
        return view('pengeluaran', compact('kategori'));
    }
    public function kategoriPengeluaran()
    {
        $kategoriPengeluaran = Kategori::where('jenis', 'pengeluaran')->where('user_id', Auth::user()->id)->get();
        return view('kategori.pengeluaran', compact('kategoriPengeluaran'));
    }
    public function kategoriPemasukan()
    {
        $kategoriPemasukan = Kategori::where('jenis', 'pemasukan')->where('user_id', Auth::user()->id)->get();
        return view('kategori.pemasukan', compact('kategoriPemasukan'));
    }

}
