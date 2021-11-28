<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<style>
    *{
        font-family: 'Poppins', sans-serif;
    }
    img[alt="www.000webhost.com"]
    {
        display:none;
        
    }
</style>
<body>
    <div id="app">
        @guest
        @yield('content')
        @else
        <div class="container" style="background-color: lightgray;">
            <div class="row justify-content-between bg-danger text-white px-3 pt-2">
                @yield('datepicker')
                <div class="col-xs-6 text-right">
                    <div class="d-flex align-items-center">
                        @if(request()->is('tahunan'))  
                        @else
                        <div class="d-flex flex-column mr-4">
                            <img src="{{ asset('images/icons8-download-48.png') }}" width='25px' class="mx-auto" onclick="event.preventDefault();
                                            document.getElementById('unduh-form').submit();">
                            <span style="font-size: 10px;" class="text-white">unduh</span>
                        </div>
                        @endif      
                        <div class="d-flex flex-column mr-4">
                            <img src="{{ asset('images/icons8-categorize-60.png') }}" alt="" width="25px" class="mx-auto" onclick="event.preventDefault();
                                            document.getElementById('category-form').submit();">
                            <span style="font-size: 10px;" class="text-white">kategori</span>
                        </div>
                        <div class="d-flex flex-column">
                            <img src="{{ asset('images/icons8-exit-48.png') }}" alt="" width="25px" class="mx-auto" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <span style="font-size: 10px;" class="text-white">keluar</span>
                        </div>
                    </div>
                    <form id="unduh-form" action="{{ route('pdf.reporting') }}" method="GET" class="d-none">
                        @csrf
                        <input type="hidden" name="tahun">
                        <input type="hidden" name="bulan">
                    </form>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <form id="category-form" action="{{ route('kategori.pengeluaran') }}" method="GET" class="d-none">
                        @csrf
                    </form>
                </div>

                <div class="d-flex w-100 justify-content-around align-items-center mt-3">
                    <!-- <p class="text-center text-white" style="border-bottom: 3px solid white; border-radius: 2px;">Harian</p> -->
                    <a href="{{ route('home') }}" class="text-center text-white font-weight-bold" style="{{ request()->is('home') ? 'border-bottom: 4px solid white;width: 60px;' : '' }}">Harian</a>
                    <a href="{{ route('bulanan') }}" class="text-center text-white font-weight-bold" style="{{ request()->is('bulanan') ? 'border-bottom: 4px solid white;width: 70px;' : '' }}">Bulanan</a>
                    <a href="{{ route('tahunan') }}" class="text-center text-white font-weight-bold" style="{{ request()->is('tahunan') ? 'border-bottom: 4px solid white;width: 70px;' : '' }}">Tahunan</a>
                </div>
            </div>

            
            @yield('content')
        </div>
        <a href="{{ route('pengeluaran') }}" class="rounded-circle fixed-bottom p-2 bg-danger text-white text-center m-3 ml-auto" style="width: 10%;"><img src="{{ asset('images/icons8-plus-math-30.png') }}" width="70%" alt=""></a>
        @endguest
    </div>
</body>
<script>
    $(document).ready(function() {
        var prevButton = $('#prev');
        var nextButton = $('#next');
        var bln_tahun = $('#bulan');
        var bulan = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
        var d = new Date();
        var m = d.getMonth();
        var y = d.getFullYear();
        let year = y;
        var bulanan = $('#bulanan');

        // init
        bln_tahun.html(`${bulan[m]} ${y}`);

        // variable month has init
        var month_original = bulan.indexOf(bln_tahun.text().split(' ')[0]) + 1;

        function month_conditional() {
            if (month_original < 1) {
                month_original += 12
            } else if (month_original > 12) {
                month_original -= 12
            }
        }

        prevButton.on('click', function() {
            let index = bulan.indexOf(bulan[bulan.indexOf(bln_tahun.text().split(' ')[0])]) - 1;
            if (index < 0) {
                index = bulan.indexOf(bulan[bulan.indexOf(bln_tahun.text().split(' ')[0])]) + 11;
                year--;
            }
            // console.log(index);
            bln_tahun.html(`${bulan[index]} ${year}`);
            month_original--;
            month_conditional();
            $("input[name='bulan']").val(month_original);
            $("input[name='tahun']").val(year);
            ajax_harian(month_original, year);
            ajax_bulanan(month_original, year);
        });
        nextButton.on('click', function() {
            let index = bulan.indexOf(bulan[bulan.indexOf(bln_tahun.text().split(' ')[0])]) + 1;
            if (index > 11) {
                index = bulan.indexOf(bulan[bulan.indexOf(bln_tahun.text().split(' ')[0])]) - 11;
                year++;
            }
            // console.log(index);
            // console.log(bulan.indexOf(bln_tahun.text().split(' ')[0]));
            bln_tahun.html(`${bulan[index]} ${year}`);
            month_original++;
            month_conditional();
            $("input[name='bulan']").val(month_original);
            $("input[name='tahun']").val(year);
            ajax_harian(month_original, year);
            ajax_bulanan(month_original, year);
        });

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        }

        function ajax_bulanan(month, year) {
            $.ajax({
                type: 'get',
                url: "/bulanan/" + month + "/" + year,
                success: function(data) {
                    let code = '';
                    if (data.bln.length === 0) {
                        code += `<div class="col-md pt-3 border">
                                    <div class="d-flex align-items-center justify-content-center text-center">
                                        <p class="text-muted text-center">Data Tidak Tersedia</p>
                                    </div>
                                </div>`
                            $('#tb_pemasukan').html(0);
                            $('#tb_pengeluaran').html(0);
                            $('#tb_saldo').html(0);
                    } else {
                        data.bln.forEach(function(value, index, array) {
                            $('#tb_pemasukan').html(formatNumber(value.total_pertahun[0].total_pemasukan));
                            $('#tb_pengeluaran').html(formatNumber(value.total_pertahun[0].total_pengeluaran));
                            $('#tb_saldo').html(formatNumber(value.total_pertahun[0].saldo));
                            code +=
                                `<div class="col-md pt-3 border">
                                    <div class="d-flex align-items-center justify-content-between text-center">
                                        <h1 class="text-white btn btn-secondary btn-md text-capitalize">${ bulan[value.month -1] }</h1>
                                        <p class="text-primary" id="totalPemasukan">Rp.${ formatNumber(value.total_pemasukan) }</p>
                                        <p class="text-danger" id="totalPengeluaran">Rp.${ formatNumber(value.total_pengeluaran) }</p>
                                    </div>
                                </div>`;
                        });
                    }
                    bulanan.html(code);
                },
            });
        }

        function ajax_harian(month, year) {
            $.ajax({
                type: 'get',
                url: "/harian/" + month + "/" + year,
                success: function(data) {
                    let code = "";
                    if (data.length === 0) {
                        $('#tt_pemasukan').html(0);
                        $('#tt_pengeluaran').html(0);
                        $('#saldo').html(0);
                        code += `<div class="row bg-white mt-2">
                                    <div class="col-md pt-3 border">
                                        <div class="d-flex align-items-center justify-content-center text-center">
                                            <p class="text-muted text-center">Data Tidak Tersedia</p>
                                        </div>
                                    </div>
                                </div>`
                    } else {
                        data.forEach(function(data) {
                            $('#tt_pemasukan').html(formatNumber(data.total_perbulan[0].total_pemasukan));
                            $('#tt_pengeluaran').html(formatNumber(data.total_perbulan[0].total_pengeluaran));
                            $('#saldo').html(formatNumber(data.total_perbulan[0].saldo));
                            code += `
                                <div class="row bg-white mt-2">
                                    <div class="col-md pt-3 border">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="btn btn-danger btn-sm text-white">${data.hari}</p>
                                                <p class="btn btn-danger btn-sm text-white">${data.tgl}</p>
                                            </div>
                                            <p class="text-primary" id="totalPemasukan">Rp.${formatNumber(data.total_pemasukan)}</p>
                                            <p class="text-danger" id="totalPengeluaran">Rp.${formatNumber(data.total_pengeluaran)}</p>
                                        </div>
                                    `
                            data.keterangan.forEach(function(keterangan) {
                                code +=`<div class="d-flex align-items-center justify-content-between">
                                                <p class="overflow-hidden text-muted py-1 text-capitalize text-nowrap mx-3 w-25">
                                                    ${keterangan.kategori.nama}
                                                </p>    
                                                <p class="overflow-auto py-1 text-nowrap w-75">
                                                    ${keterangan.keterangan}
                                                </p>    
                                                
                                                ${(keterangan.pemasukan) 
                                                ? `<p class="text-primary">Rp. ${formatNumber(keterangan.pemasukan)}</p>` 
                                                : `<p class="text-danger">Rp.${formatNumber(keterangan.pengeluaran)} </p>`}
                                                
                                        </div>
                                    `;
                            })
                            code += `</div>
                                </div>`;
                        })
                        
                    }
                    $('#harian').html(code);
                }
            })
        }

        function msg_alert(){
            var msg = "{{Session::get('alert')}}";
            var exist = "{{Session::has('alert')}}";
            if(exist){
                alert(msg);
            }
        }

        $("input[name='bulan']").val(month_original);
        $("input[name='tahun']").val(year);
        ajax_bulanan(month_original, year);
        ajax_harian(month_original, year);
        msg_alert();
    });
</script>
@yield('embedjs')
</html>