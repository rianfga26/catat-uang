@extends('layouts.app')

@section('datepicker')
<div class="col-xs-6">
    <span id="prev" style="cursor: pointer;"><</span>
    <span id="bulan" class="text-capitalize"></span> 
    <span id="next" style="cursor: pointer;">></span>
</div>
@endsection

@section('content')
    <div class="row bg-white justify-content-around pt-3 text-center">
        <div class="col-xs-4">
            <h5>Pemasukan</h5>
            <p class="text-center font-weight-normal text-primary" id="tt_pemasukan"></p>
        </div>
        <div class="col-xs-4">
            <h5>Pengeluaran</h5>
            <p class="text-center text-danger" id="tt_pengeluaran">0</p>
        </div>
        <div class="col-xs-4">
            <h5>Saldo</h5>
            <p class="text-center" id="saldo">10.000.000</p>
        </div>
    </div>
    <div id="harian"></div>
@endsection
