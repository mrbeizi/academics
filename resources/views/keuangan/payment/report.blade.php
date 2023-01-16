<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td {
            font-size: 9pt;
        }
		table tr th{
			font-size: 9pt;
            text-align: center;
		}
        #range-date{
            font-size: 11pt;
            margin-bottom: 1.5em;
        }
        #print-date{
            font-size: 7pt;
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
        <h5>LAPORAN REKAPITULASI PEMBAYARAN BIAYA KULIAH</h4>
        <p id="range-date">Tanggal: {{tanggal_indonesia($start_date)}} sd {{tanggal_indonesia($end_date)}}</p>
    </div>
 
	<table class='table table-bordered'>
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
			@php $i=1; $grandTotal = 0; @endphp
			@foreach($data as $p)
			<tr>
				<td align="center">{{ $i++ }}</td>
				<td align="center">{{$p->nim_mahasiswa}}</td>
				<td>{{$p->nama_mahasiswa}}</td>
				<td align="center">{{$p->kode_prodi}}</td>
				<td align="center">{{$p->semester}}</td>
				<td align="right">Rp. {{ number_format($p->jumlah_bayar,0,',','.') }}</td>
				<td>{{$p->keterangan}}</td>
			</tr>
            @php $grandTotal += $p->jumlah_bayar; @endphp
			@endforeach
            <tr>
                <td colspan="5" align="center"><b>Grand Total</b></td>
                <td align="right"><b>Rp. {{ number_format($grandTotal,0,',','.') }}</b></td>
                <td align="right"><b>Rp. {{ number_format($grandTotal,0,',','.') }}</b></td>
            </tr>
		</tbody>
	</table>

    <p id="print-date">Printed date: {{tanggal_indonesia(now())}}</p>
 
</body>
</html>