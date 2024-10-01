@extends('layouts.main')

@section('navbar')
    @include('partials.navbar')
@endsection

@section('body')
    <div class="container py-5 containbg my-3">
        <h3 class="text-center"><b>Detail Pembayaran</b></h3>
        <div class="nota greetings">
            <b>Terima Kasih</b>
            <p>Pesanan anda berhasil dibuat. Masa berlaku untuk No. Transaksi ini 24 jam, segera lakukan pembayaran agar pesanan segera diproses.</p>
            <p>Simpan No. Transaksi anda untuk Cek Status Pesanan!</p>
        </div>
        <div class="nota detail">
            <div class="row">
                <div class="col">
                    <b>ID Game</b>
                    <p>{{ $transaksi->id_game }}</p>
                    <b>Metode Pembayaran</b>
                    <p>{{ $transaksi->payment->method }}</p>
                    <b>No. Rekening/ No. Virtual Account</b>
                    <p>{{ $transaksi->payment->number }}</p>
                    <b>Jumlah Pembayaran</b>
                    <p>{{ 'Rp.' . number_format($transaksi->item->price, 2, ",", ".") }}</p>
                    <b>Selesaikan Transaksi Sebelum</b>
                    <p><span id="countdown-{{ $transaksi->id }}"></span></p>
                </div>
                <div class="col">
                    <b>No. transaksi</b>
                    <p>{{ $transaksi->id_transaksi}}</p>
                    <b>Waktu transaksi</b>
                    <p>{{ $transaksi->created_at }}</p>
                    <b>Rincian Pemesanan</b>
                    <p>{{ $transaksi->game->game }}</p>
                    <b>Keterangan/ No. Token/ No. Voucher</b>
                    <p>{{ $transaksi->status }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
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
    @include('partials.footer')
@endsection