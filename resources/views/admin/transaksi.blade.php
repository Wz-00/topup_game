@extends('layouts.main')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbaradmin')
@endsection

@section('body')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
<div class="container-fluid">
    <div class="containadmin p-4">
        <div class="row">
            <div class="col-xl-12">
                <div class="card my-3">
                    <div class="card-body">
                        <h4 class="header-title pb-3 mt-0">Transaction List</h4>
                        <!-- Ambil dari database -->
                        <!-- jika status sukses, badge primary. jika status belum selesai, badge warning. jika status dibatalkan, badge danger -->
                        <table class="table table-hover table-dark" id="example">
                            <thead>
                                <tr class="align-self-center">
                                    <th scope="col">Game</th>
                                    <th scope="col">Game ID</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Payment Type</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaksi)
                                    <tr>
                                        <td>{{ $transaksi->game->game }}</td>
                                        <td>{{ $transaksi->id_game }}</td>
                                        <td>
                                            @if ($transaksi->user_id === null)
                                                Guest
                                            @else
                                                {{ $transaksi->user->name }}
                                            @endif
                                        </td>
                                        <td>{{ $transaksi->id_transaksi }}</td>
                                        <td>{{ $transaksi->payment->method }}</td>
                                        <td>{{ $transaksi->item->item }}</td>
                                        <td>{{ 'Rp.' . number_format($transaksi->item->price, 2, ",", ".") }}</td>
                                        <td>
                                            @if ($transaksi->status === 'Menunggu Pembayaran')
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
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td><span id="status" class="badge text-bg-warning" style="width: 100%; font-weight: 100px; font-size:14px">{{ $transaksi->status }}</span></td>
                                        <td class="text-center">
                                            <form id="transaksiForm{{ $transaksi->id }}" action="{{ route('update.status', $transaksi->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" id="transaksiID" name="transaction_id" value="{{ $transaksi->id }}">
                                                <input type="hidden" id="statusField" name="status" value="{{ $transaksi->status === 'Menunggu Pembayaran' ? 'Konfirmasi Pembayaran' : 'Proses' }}">
                                                @if (now()->format('Y-m-d H:i:s') === $transaksi->created_at->addDay()->format('Y-m-d H:i:s') && $transaksi->status === 'Menunggu Pembayaran')
                                                    <script>
                                                        var id = document.getElementById('transaksiID');
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            // Ubah status menjadi "Gagal" dan auto-submit form
                                                            document.getElementById('statusField').value = 'Gagal';
                                                            document.getElementById('transaksiForm' + id).submit();
                                                        });
                                                    </script>
                                                @else
                                                    @if ($transaksi->status === 'Menunggu Pembayaran')
                                                        <button class="btn btn-primary" type="button" onclick="confirmPayment({{ $transaksi->id }})">Konfirmasi Pembayaran</button>
                                                    @elseif($transaksi->status === 'Proses')
                                                        <button class="btn btn-primary" type="button" onclick="">Selesaikan Proses</button>
                                                    @endif
                                                @endif
                                            </form>
                                        </td>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        
        function confirmPayment(transaksiID){
            Swal.fire({
            title: "Terima Pembayaran",
            html: "Apakah User dengan Id Transaksi " + transaksiID + " sudah menyelesaikan pembayaran ?",
            showDenyButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                document.getElementById('transaksiForm' + transaksiID).submit();
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
            });
        }
    </script>
@endsection