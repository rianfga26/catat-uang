@extends('transaksi.tambah')

@section('judul', 'Kategori')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
@endsection
@section('icon')
<a href="" class="ml-auto mr-3" data-toggle="modal" data-target="#exampleModal"><img src="{{ asset('images/icons8-plus-math-30.png') }}" width="20px" alt=""></a>

<!-- Modal -->
<div class="modal fade {{ $errors->any() ? 'show' : '' }}" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="{{ $errors->any() ? 'display:block;' : '' }}">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
      </div>
        <form action="{{ route('tambah.kategori') }}" method="POST">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nama Kategori</label>
                    <input type="text" class="form-control" name="nama" id="exampleFormControlInput1" placeholder="belanja">
                    @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="w-100">Jenis Kategori</label>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="jenis" class="custom-control-input" value="pemasukan">
                        <label class="custom-control-label" for="customRadioInline1">Pemasukan</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="jenis" class="custom-control-input" value="pengeluaran">
                        <label class="custom-control-label" for="customRadioInline2">Pengeluaran</label>
                    </div>
                    @error('jenis')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection
@section('link')
<div class="{{ request()->is('kategori/pengeluaran') ? 'bg-danger' : 'backgroundf7' }} border rounded py-1 px-3">
    <a href="{{ route('kategori.pengeluaran') }}" class="text-decoration-none {{ request()->is('kategori/pengeluaran') ? 'text-white' : 'text-dark' }} lead text-capitalize ">pengeluaran</a>
</div>
<div class="px-3 py-1 rounded border {{ request()->is('kategori/pemasukan') ? 'bg-primary' : 'backgroundf7' }}">
    <a href="{{ route('kategori.pemasukan') }}" class="text-decoration-none lead text-capitalize {{ request()->is('kategori/pemasukan') ? 'text-white' : 'text-dark' }}">pemasukan</a>
</div>
@endsection
@section('content')
    
    @foreach($kategoriPengeluaran as $kategori)
    <div class="col-md-12 border">
        <div class="d-flex py-3 align-items-center justify-content-between">
            <div class="text-capitalize">{{ $kategori->nama }}</div>
            <div>
                <a href="{{ route('kategori.hapus', $kategori->id) }}"><img src="{{ asset('images/icons8-delete-64.png') }}" alt="" width="20px"></a>
            </div>
        </div>
    </div>
@endforeach
@endsection