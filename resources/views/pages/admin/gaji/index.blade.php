@extends('layouts.admindashboard')

@section('content')
{{-- HEADER --}}
<main>
    <div class="container mt-5">
        <!-- Custom page header alternative example-->
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="mr-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Data Gaji Pegawai</h1>
                <div class="small">
                    <span class="font-weight-500 text-primary">{{ $today }}</span>
                    · Tanggal {{ $tanggal }} · <span id="clock">12:16 PM</span>
                </div>
            </div>
            <div class="small">
                <i class="fas fa-file-excel" aria-hidden="true"></i>
                    Excel Format <a href="{{ route('download_excel_format') }}">Download</a>
                <span class="font-weight-500 text-primary"></span>
                <hr>
                </hr>
            </div>
        </div>
    </div>

    @if(session('messagegagal'))
    <div class="container-fluid">
        <div class="alert alert-danger alert-icon" id="alertgagal" role="alert">
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="alert-icon-aside">
                <i class="fas fa-file-excel"></i>
            </div>
            <div class="alert-icon-content">
                <h6 class="alert-heading">Import Gagal!</h6>
                {{ session('messagegagal') }}
            </div>
        </div>
    </div>
    @endif

    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card card-header-actions">
                <div class="card-header">List Gaji Pegawai
                    <a href="" class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                        data-target="#Modaltambah">
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="datatable">

                    @if(session('messageberhasil'))
                    <div class="alert alert-success" role="alert"> <i class="fas fa-check"></i>
                        {{ session('messageberhasil') }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                    @if(session('messagehapus'))
                    <div class="alert alert-danger" role="alert"> <i class="fas fa-check"></i>
                        {{ session('messagehapus') }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif

                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTable" width="100%"
                                    cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 10px;">
                                                No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 40px;">Tahun Gaji</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 80px;">Bulan Gaji</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 80px;">Jumlah Pegawai</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Actions: activate to sort column ascending"
                                                style="width: 90px;">Penerimaan Lain Lain</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Actions: activate to sort column ascending"
                                                style="width: 70px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($gaji as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}.</th>
                                            <td>{{ date('Y', strtotime($item->bulan_gaji)) }}</td>
                                            <td>{{ date('F', strtotime($item->bulan_gaji)) }}</td>
                                            <td>{{ $item->detailgaji_count }} Orang</td>
                                     
                                            @if ($item->status_penerimaan_lain == 'Belum Ditambahkan')
                                                <td class="text-center">
                                                    <a href="" class="btn-xs btn-facebook mr-2" type="button"
                                                    data-toggle="modal"
                                                    data-target="#Modalupdate-{{ $item->id_gaji_pegawai }}">
                                                    Upload Peneriman Lain
                                                    </a>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    <span class="badge badge-success">Telah Ditambahkan</span>
                                                </td>
                                            @endif
                                           
                                            <td class="text-center">
                                                <a href="{{ route('gaji.show', $item->id_gaji_pegawai) }}"
                                                    class="btn btn-secondary btn-datatable mr-2"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Detail dan Edit">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="" class="btn btn-danger btn-datatable  mr-2" type="button"
                                                    data-toggle="modal"
                                                    data-target="#Modalhapus-{{ $item->id_gaji_pegawai }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>





<div class="modal fade" id="Modaltambah" tabindex="-1" role="dialog" data-backdrop="static"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Gaji Pegawai</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('gaji.store') }}" id="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label class="small mb-1">Isi Formulir Berikut</label>

                    @if($errors->any())
                    <div class="alert alert-danger" role="alert"> <i class="fas fa-times"></i>
                        {{$errors->first()}}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif

                    <hr>
                    </hr>
                    <div class="form-group">
                        <label class="small mb-1 mr-1" for="bulan_gaji">Bulan dan Tahun Bayar</label><span
                            class="mr-4 mb-3" style="color: red">*</span>
                        <input class="form-control" id="bulan_gaji" type="month" name="bulan_gaji" value="{{ old('bulan_gaji') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1 mr-1" for="excel">Upload File Excel</label><span class="mr-4 mb-3"
                            style="color: red">*</span>
                        <input class="form-control" id="excel" type="file" name="excel" accept=".xlsx, .xls, .csv"
                            value="{{ old('excel') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit">Selanjutnya!</button>
                </div>
            </form>
        </div>
    </div>
</div>

@forelse ($gaji as $item)
<div class="modal fade" id="Modalhapus-{{ $item->id_gaji_pegawai }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger-soft">
                <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi Hapus Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('gaji.destroy', $item->id_gaji_pegawai) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <div class="modal-body text-center">Apakah Anda Yakin Menghapus Data Gaji Pegawai pada Bulan
                    <b>{{ date('F', strtotime($item->bulan_gaji)) }} </b> , Tahun
                    <b>{{ date('Y', strtotime($item->bulan_gaji)) }}</b> ?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger" type="submit">Ya! Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@empty

@endforelse

@forelse ($gaji as $item)
    <div class="modal fade" id="Modalupdate-{{ $item->id_gaji_pegawai }}" tabindex="-1" role="dialog" data-backdrop="static"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Atur Penerimaan Lain-Lain</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('tambahpenerimaanlain', $item->id_gaji_pegawai) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label class="small mb-1">Upload File Excel dengan format nama dan penerimaan lain-lain</label>
                        <hr>
                        </hr>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="small mb-1 mr-1" for="bulan_gaji">Bulan dan Tahun Bayar</label>
                                <input class="form-control" id="bulan_gaji" type="text" name="bulan_gaji" value="{{ date('F', strtotime($item->bulan_gaji)) }} {{ date('Y', strtotime($item->bulan_gaji)) }}" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1 mr-1" for="jumlah_pegawai">Jumlah Pegawai</label>
                                <input class="form-control" id="jumlah_pegawai" type="text" name="jumlah_pegawai" value="{{ $item->detailgaji_count }} Orang" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="excelupdate">Upload File Excel Penerimaan Lainnya</label><span class="mr-4 mb-3"
                                style="color: red">*</span>
                            <input class="form-control" id="excelupdate" type="file" name="excelupdate" accept=".xlsx, .xls, .csv"
                                value="{{ old('excelupdate') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-success" type="submit">Upload!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@empty

@endforelse

@if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
<button id="validasierror" style="display: none" type="button" data-toggle="modal" data-target="#Modaltambah">Open
    Modal</button>
@endif
<script>
    $(document).ready(function () {
        $('#validasierror').click();
    });

    setInterval(displayclock, 500);

    function displayclock() {
        var time = new Date()
        var hrs = time.getHours()
        var min = time.getMinutes()
        var sec = time.getSeconds()
        var en = 'AM';

        if (hrs > 12) {
            en = 'PM'
        }

        if (hrs > 12) {
            hrs = hrs - 12;
        }

        if (hrs == 0) {
            hrs = 12;
        }

        if (hrs < 10) {
            hrs = '0' + hrs;
        }

        if (min < 10) {
            min = '0' + min;
        }

        if (sec <  10) {
            sec = '0' + sec;
        }

        document.getElementById('clock').innerHTML = hrs + ':' + min + ':' + sec + ' ' + en;
    }

   

</script>

@endsection
