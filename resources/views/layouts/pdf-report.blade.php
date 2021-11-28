<?php setlocale (LC_TIME, 'id_ID'); ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist&display=swap" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel')}}</title>
  </head>
  <style>
    * {
      font-family: 'Urbanist', sans-serif;
    }
  </style>
  <body>
    <div class="container">
      <div class="row my-5 justify-content-center">
        <div class="col-md-12">
          <h3 class="font-weight-bolder text-center mb-4">Laporan Keuangan</h3>
          <div class="border border-bottom border-dark"></div>
          <div class="border border-bottom mt-1 border-dark"></div>
          <table class="mt-3">
            <tr>
              <th class="pr-5">Nama</th>
              <td>:</td>
              <td>{{  Auth::user()->name }}</td>
            </tr>
            <tr>
              <th class="pr-5">Bulan</th>
              <td>:</td>
              <td>{{  \Carbon\Carbon::create($total_perbulan[0]->year, $total_perbulan[0]->month)->locale('id')->monthName }}</td>
            </tr>
            <tr>
              <th class="pr-5">Tahun</th>
              <td>:</td>
              <td>{{ $total_perbulan[0]->year }}</td>
            </tr>
            <tr>
              <th class="pr-5">Pemasukan</th>
              <td>:</td>
              <td>Rp {{ number_format($total_perbulan[0]->total_pemasukan,0,',','.') }}</td>
            </tr>
            <tr>
              <th class="pr-5">Pengeluaran</th>
              <td>:</td>
              <td>Rp {{ number_format($total_perbulan[0]->total_pengeluaran,0,',','.') }}</td>
            </tr>
            <tr>
              <th class="pr-5">Saldo</th>
              <td>:</td>
              <td>Rp {{ number_format($total_perbulan[0]->saldo,0,',','.') }}</td>
            </tr>
          </table>
          <table class="table mt-4">
            <thead class="border-top border-start-0 border-end-0 border-2 border-dark">
              <tr class="text-center">
                <th>No</th>
                <th>Tanggal</th>
                <th>Transaksi</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Kategori</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data_perbulan as $key)
              <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($key->created_at)
                ->locale('id')->isoFormat('LL') }}</td>
                <td>{{ $key->keterangan }}</td>
                <td>Rp {{ number_format($key->pemasukan,0,',','.') }}</td>
                <td>Rp {{ number_format($key->pengeluaran,0,',','.') }}</td>
                <td class="text-capitalize"> {{ $key->kategori->nama }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="border border-bottom border-dark mt-5"></div>
          <div class="border border-bottom mt-1 border-dark"></div>
          <p>File ini dibuat oleh <span class="font-weight-bold"><a href="{{ config('app.url')}}" class="text-decoration-none text-dark">{{ config('app.name', 'Laravel')}}</a></span></p>
        </div>
      </div>
    </div>
  </body>
</html>