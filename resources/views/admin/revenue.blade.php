@extends('layouts.main')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbaradmin')
@endsection

@section('body')
<style>
    /* .canvas {
        width: 100%;
        max-width: 900px;
    } */
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
<div class="container-fluid">
    <div class="canvas mx-4 mb-3">
        <canvas id="myChart" height="600" aria-label="Hello ARIA World" role="img" style="background-color: white;"></canvas>
    </div>
    <div class="containadmin p-4">
        <div class="row">
            <div class="col-xl-12">
                <div class="card my-3">
                    <div class="card-body">
                        <h4 class="header-title pb-3 mt-0">Revenue</h4>
                        <!-- Ambil dari database -->
                        <!-- jika status sukses, badge primary. jika status belum selesai, badge warning. jika status dibatalkan, badge danger -->
                        <table class="table table-hover table-dark" id="example">
                            <thead>
                                <tr class="align-self-center">
                                    <th scope="col">Game</th>
                                    <th scope="col">Game ID</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Payment Type</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($transactions as $transaksi)
                                        <tr>
                                            <td>{{ $transaksi->game->game }}</td>
                                            <td>{{ $transaksi->id_game }}</td>
                                            <td>{{ $transaksi->id_transaksi }}</td>
                                            <td>{{ $transaksi->payment->method }}</td>
                                            <td>{{ $transaksi->item->item }}</td>
                                            <td>{{ 'Rp.' . number_format($transaksi->item->price, 2, ",", ".") }}</td>
                                            @if ($transaksi->status == 'Berhasil')
                                                <td><span class="badge text-bg-success" style="width: 100%; font-weight: 100px; font-size:14px">{{ $transaksi->status }}</span></td>    
                                            @else
                                                <td><span class="badge text-bg-danger" style="width: 100%; font-weight: 100px; font-size:14px">{{ $transaksi->status }}</span></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('footer')
    @include('partials.adminfooter')
@endsection