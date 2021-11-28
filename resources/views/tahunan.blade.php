@extends('layouts.app')
@section('datepicker')
<h5>Total</h5>
@endsection
@section('content')
@isset($tahunan)
<div class="row bg-white justify-content-around pt-3 text-center">
    <div class="col-xs-4">
        <h5>Pemasukan</h5>
        <p class="text-center font-weight-normal text-primary">{{ number_format($tahunan[0]->total[0]->total_pemasukan,0,',','.') }}</p>
    </div>
    <div class="col-xs-4">
        <h5>Pengeluaran</h5>
        <p class="text-center text-danger">{{ number_format($tahunan[0]->total[0]->total_pengeluaran,0,',','.') }}</p>
    </div>
    <div class="col-xs-4">
        <h5>Saldo</h5>
        <p class="text-center">{{ number_format($tahunan[0]->total[0]->saldo,0,',','.') }}</p>
    </div>
</div>
<div class="row bg-white mt-2">
    @foreach($tahunan as $tahun)
    <div class="col-md pt-3 border">
        <div class="d-flex align-items-center justify-content-between text-center">
            <h1 class="text-white btn btn-secondary btn-md text-capitalize">{{ $tahun->year }}</h1>
            <p class="text-primary">Rp.{{ number_format($tahun->total_pemasukan,0,',','.') }}</p>
            <p class="text-danger">Rp.{{ number_format($tahun->total_pengeluaran,0,',','.') }}</p>
        </div>
    </div>
    @endforeach
</div>
@endisset
@empty($tahunan)
<div class="row bg-white justify-content-around pt-3 text-center">
    <div class="col-xs-4">
        <h5>Pemasukan</h5>
        <p class="text-center font-weight-normal text-primary">0</p>
    </div>
    <div class="col-xs-4">
        <h5>Pengeluaran</h5>
        <p class="text-center text-danger">0</p>
    </div>
    <div class="col-xs-4">
        <h5>Saldo</h5>
        <p class="text-center">0</p>
    </div>
</div>
<div class="row bg-white mt-2">
    <div class="col-md pt-3 border">
        <div class="d-flex align-items-center justify-content-center text-center">
            <p class="text-muted text-center">Data Tidak Tersedia</p>
        </div>
    </div>
</div>
@endempty
@endsection