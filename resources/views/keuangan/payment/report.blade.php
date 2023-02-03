<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td {
            font-size: 8pt;
        }
		table tr th{
			font-size: 8pt;
            text-align: center;
		}
		.author p{
			font-size: 9pt;
		}
        #range-date{
            font-size: 8pt;
            margin-bottom: 1.5em;
        }
        #print-date{
            font-size: 6pt;
            float: right;
        }
        #logo img {
            width: 20%;
            margin-top: 0em;
            margin-bottom: 1.0em;
        }
	</style>
    <div id="logo">
        <img src="{{asset('template/images/head.png')}}" alt="header">
        <h5>LAPORAN REKAPITULASI PEMBAYARAN BIAYA KULIAH</h5>
        <p id="range-date">Angkatan: <b>{{$angkatan}}</b> -- Tanggal: {{tanggal_indonesia($start_date)}} sd {{tanggal_indonesia($end_date)}}</p>
    </div>
 
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>#</th>
				<th>NIM</th>
				<th>Nama MHS</th>
				<th>Prodi</th>
				<th>SMT</th>
				<th>Jumlah Bayar</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1; $totalKategoriA = 0; @endphp
			@foreach($dataPayment as $payment)
			<tr>
				<td align="center">{{ $i++ }}</td>
				<td align="center">{{$payment->nim_mahasiswa}}</td>
				<td>{{$payment->nama_mahasiswa}}</td>
				<td align="center">{{$payment->kode_prodi}}</td>
				<td align="center">{{$payment->semester}}</td>
				<td align="right">Rp. {{ number_format($payment->jumlah_bayar,0,',','.') }}</td>
				<td>{{$payment->keterangan}}</td>
			</tr>
            @php $totalKategoriA += $payment->jumlah_bayar; @endphp
			@endforeach
			@php $totalKategoriB = 0; @endphp
			@foreach($dataDenda as $key => $val)
				@foreach($val as $k => $v)
				@php $totalKategoriB += $v->total_denda; @endphp
					<tr>
						@if($k == 0)
						<td style="vertical-align: middle;" align="center" colspan="5" rowspan="{{count($val)}}">Total Denda {{$v->kode_prodi}}</td>
						@endif
						<td align="right">Rp. {{ number_format($v->total_denda,0,',','.') }}</td>
						@if($k == 0)
						<td align="right" style="vertical-align: middle;" rowspan="{{count($val)}}">Rp. {{ number_format($v->total_denda,0,',','.') }}</td>
						@endif
					</tr>
				@endforeach
			@endforeach
			@php $grandTotal = $totalKategoriA+$totalKategoriB; @endphp
            <tr>
                <td colspan="5" align="center"><b>Grand Total</b></td>
                <td align="right"><b>Rp. {{ number_format($grandTotal,0,',','.') }}</b></td>
                <td align="right"><b>Rp. {{ number_format($grandTotal,0,',','.') }}</b></td>
            </tr>
		</tbody>
	</table>

    <p id="print-date">Printed date: {{tanggal_indonesia(now())}}</p>

	<div class="mt-3 author">
		<p>Dibuat oleh:</p>
		<p class="mt-2">{{Auth::user()->name}}</p>
	</div>
 
</body>
</html>