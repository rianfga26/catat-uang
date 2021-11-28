@extends('transaksi.tambah')

@section('judul', 'Tambah Transaksi')

@section('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(function() {
    $("#datepicker").datepicker({});
});
</script>
@endsection

@section('link')
<div class="{{ request()->is('transaksi/pengeluaran') ? 'bg-danger' : 'backgroundf7' }} border rounded py-1 px-3">
    <a href="{{ route('pengeluaran') }}" class="text-decoration-none {{ request()->is('transaksi/pengeluaran') ? 'text-white' : 'text-dark' }} lead text-capitalize ">pengeluaran</a>
</div>
<div class="px-3 py-1 rounded border {{ request()->is('transaksi/pemasukan') ? 'bg-primary' : 'backgroundf7' }}">
    <a href="{{ route('pemasukan') }}" class="text-decoration-none lead text-capitalize {{ request()->is('transaksi/pemasukan') ? 'text-white' : 'text-dark' }}">pemasukan</a>
</div>
@endsection
@section('content')
<div class="col-sm-8">
    <form action="{{ route('transaksi.pemasukan') }}" method="POST">
    @csrf
    <div class="form-group row justify-content-between">
        <label for="colFormLabel" class="col-sm-6 col-form-label font-weight-bold ">Tanggal</label>
        <div class="col-sm-6">
            <input type="text" class="form-control " id="datepicker" name="tgl" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <label for="colFormLabel" class="col-sm-6 col-form-label font-weight-bold mr-auto">Kategori</label>
        <div class="col-sm-6">
            <select class="custom-select text-wrap" name="kategori" >
                <option value="" selected>Pilih Kategori</option>
                @foreach($kategori as $cat)
                <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                @endforeach
            </select>
            @error('kategori')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="form-group row justify-content-between">
        <label for="colFormLabel" class="col-sm-6 col-form-label font-weight-bold mr-3">Jumlah</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" autocomplete="off" id="rupiah" name="jumlah">
        </div>
    </div>
    <div class="form-group row justify-content-between">
        <label for="colFormLabel" class="col-sm-6 col-form-label font-weight-bold mr-3">Keterangan</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="colFormLabel" name="keterangan">
        </div>
    </div>
    <div class="row justify-content-center mt-5 mb-3">
        <button type="submit" class="btn btn-danger">Simpan</button>
    </div>
</form>
</div>
@endsection