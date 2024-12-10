@extends('layouts.main')

@section('body')
<style>
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
    @media (max-width:767px){
        .kiri {
            border-top-right-radius: 7px;
            border-bottom-left-radius: 0px;
        }
        .kanan {
            border-bottom-left-radius: 7px;
            border-top-right-radius: 0px;
        }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
    <div class="container">
        <div class="containbg p-4 my-3">
            
            @if ($transactions->where('status', 'Menunggu Pembayaran'))
                <h3 class="mb-3">Selesaikan Transaksimu sebelum 24jam</h3>
                <table class="table table-hover table-dark" id="example">
                    <thead>
                        <tr class="align-self-center">
                            <th scope="col">ID Transaksi</th>
                            <th scope="col">Game</th>
                            <th scope="col">ID Game</th>
                            <th scope="col">Metode Pembayaran</th>
                            <th scope="col">No. Rekening</th>
                            <th scope="col">Jumlah Pembayaran</th>
                            <th scope="col">Batas Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unpaid as $key => $transaksi)
                            <tr>
                                <td>{{ $transaksi->id_transaksi }}</td>
                                <td>{{ $transaksi->game->game }}</td>
                                <td>{{ $transaksi->id_game }}</td>
                                <td>{{ $transaksi->payment->method }}</td>
                                <td>{{ $transaksi->payment->number }}</td>
                                <td>{{ $transaksi->item->price }}</td>
                                <td>
                                    <span id="countdown-{{ $transaksi->id }}"></span>
                                    <script>
                                        var dueTime{{ $transaksi->id }} = new Date("{{ $transaksi->created_at->addDay()->format('Y-m-d H:i:s') }}").getTime();
                                        
                                        var countdownFunction{{ $transaksi->id }} = setInterval(function() {
                                            var now = new Date().getTime();
                                            var distance = dueTime{{ $transaksi->id }} - now;
                                            
                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                            document.getElementById("countdown-{{ $transaksi->id }}").innerHTML =
                                                hours + "h " + minutes + "m " + seconds + "s ";

                                            if (distance < 0) {
                                                clearInterval(countdownFunction{{ $transaksi->id }});
                                                document.getElementById("countdown-{{ $transaksi->id }}").innerHTML = "Expired";

                                                // Mengubah status transaksi menjadi Gagal jika expired
                                                document.getElementById('statusField').value = 'Gagal';
                                                document.getElementById('transaksiForm{{ $transaksi->id }}').submit();
                                            }
                                        }, 1000);
                                    </script>
                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            <hr class="my-5">
            @endif
            <h3>List Transaksi</h3>
            <table class="table table-hover table-dark" id="contoh">
                <thead>
                    <tr class="align-self-center">
                        <th scope="col">ID Transaksi</th>
                        <th scope="col">Game</th>
                        <th scope="col">ID Game</th>
                        <th scope="col">Metode Pembayaran</th>
                        <th scope="col">Jumlah Pembayaran</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $key => $transaksi)
                    <tr>
                        <td>{{ $transaksi->id_transaksi }}</td>
                        <td>{{ $transaksi->game->game }}</td>
                        <td>{{ $transaksi->id_game }}</td>
                        <td>{{ $transaksi->payment->method }}</td>
                        <td>{{ $transaksi->item->price }}</td>
                        <td>{{ $transaksi->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row reward p-3" id="rewards">
                <div class="col-md-6 col-12 kiri p-3">
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
@endsection

@section('footer')
    @include('partials.footer')
    <script>
        // datatable
        new DataTable('#contoh', {
        scrollX: true
        });
    </script>
@endsection