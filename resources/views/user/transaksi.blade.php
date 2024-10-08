@extends('layouts.main')

@section('body')
<style>
    .reward {
    }
    .kiri {
        border-top-left-radius: 7px;
        border-bottom-left-radius: 7px;
        background-color: #1f2122;
    }
    .kanan {
        background-color: #424242;
        border-bottom-right-radius: 7px;
        border-top-right-radius: 7px;
    }
</style>
    <div class="container">
        <div class="containbg p-4 my-3">
            <h3>List Transaksi</h3>
            <div class="row">
                <div class="col-12 my-2">
                    @if ($transactions->where('status', 'Menunggu Pembayaran')->isNotEmpty())
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="card-title mb-4"><h4>Selesaikan Pembayaran</h4></div>
                                <div class="row">
                                    <div class="col-1">No.</div>
                                    <div class="col-2">ID Transaksi</div>
                                    <div class="col-1">Game</div>
                                    <div class="col-2">ID Game</div>
                                    <div class="col-2">Metode Pembayaran</div>
                                    <div class="col-2">No. Rekening</div>
                                    <div class="col-2">Jumlah Pembayaran</div>
                                </div>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($transactions as $key => $transaksi)
                                    @if ($transaksi->status === 'Menunggu Pembayaran')
                                        <hr color="white">
                                        <div class="row mb-3">
                                            <div class="col-1">{{ $i++ }}</div>
                                            <div class="col-2">{{ $transaksi->id_transaksi }}</div>
                                            <div class="col-1">{{ $transaksi->game->game }}</div>
                                            <div class="col-2">{{ $transaksi->id_game }}</div>
                                            <div class="col-2">{{ $transaksi->payment->method }}</div>
                                            <div class="col-2">{{ $transaksi->payment->number }}</div>
                                            <div class="col-2">{{ $transaksi->item->price }}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-1">No.</div>
                                <div class="col-2">ID Transaksi</div>
                                <div class="col-1">Game</div>
                                <div class="col-2">ID Game</div>
                                <div class="col-2">Metode Pembayaran</div>
                                <div class="col-2">No. WA</div>
                                <div class="col-2">Status</div>
                            </div>
                            <hr color="white">
                            @foreach ($transactions as $key => $transaksi)
                                @if ($transaksi->status !== 'Menunggu Pembayaran')
                                    <div class="row mb-3">
                                        <div class="col-1">{{ $key +=1 }}</div>
                                        <div class="col-2">{{ $transaksi->id_transaksi }}</div>
                                        <div class="col-1">{{ $transaksi->game->game }}</div>
                                        <div class="col-2">{{ $transaksi->id_game }}</div>
                                        <div class="col-2">{{ $transaksi->payment->method }}</div>
                                        <div class="col-2">{{ $transaksi->Wa_Number }}</div>
                                        <div class="col-2">{{ $transaksi->status }}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row reward p-3" id="rewards">
                        <div class="col kiri p-3">
                            <h3><span class="iconify" data-icon="streamline:dollar-coin-solid" data-inline="false"
                                style="color:#fbff00;"></span> Reward Coin Kamu</h3>
                        </div>
                        <div class="col kanan p-3">
                            <h3>{{ $user->coins === null ? '0' : $user->coins }}</h3>
                        </div>
                    </div>
                    <ol class="p-3">
                        <li><h4>Tentang Rewards</h4></li>
                        <li>Dapatkan Coin Rewards untuk pembelian Anda di {{ $company->name }} dengan menggunakan metode pembayaran yang memenuhi syarat</li>
                        <li>Coin Rewards Anda akan disimpan di akun {{ $company->name }} Anda</li>
                        <li>Coin Rewards dapat digunakan untuk transaksi anda selanjutnya!</li>
                    </ol>
                </div>
            </div>   
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection