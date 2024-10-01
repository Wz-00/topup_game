@extends('layouts.main')

@section('navbar')
    @include('partials.navbar')
@endsection

@section('body')
    <style>
        .disabled {
            opacity: 0.3;
            pointer-events: none;
        }
        .head {
            font-size: 4em;
            font-family: fantasy; 
        }
    </style>
    <div class="container containbg ">
        <div class="d-flex justify-content-center">
            <h1 class="head">{{ $games->game }}</h1>
        </div>
        <div class="grid" style="--bs-columns: 3;">
            <div class="g-col-3 g-col-lg-1">
                <div class="content p-3">
                    <img src="{{ asset('storage/' . $games->image) }}" alt="" class="img-fluid">
                    <div class="p-2">
                        <h4 class="text-white">{{ $games->game }}</h4>
                        <p class="text-white">{!! $games->description !!}</p>
                    </div>
                </div>
            </div>
            <!-- Form Transaksi -->
            <div class="g-col-3 g-col-lg-2">
                <form id="transaksiForm" action="{{ url('/{game:slug}') }}" method="POST">
                    @csrf
                    <!-- Id Game -->
                    <div class="mb-4 bgform">
                        <span class="rounded-circle number"><b>1</b></span>
                        <span style="font-size: 25px; font-weight: bold;">Masukkan Game ID</span>
                        <div class="mb-3 form-floating">
                            <input type="text" id="floatingInput" name="id_game" class="form-control" placeholder="Riot ID"/>
                            <label for="floatingInput" class="text-black">ID Game</label>
                        </div>
                    </div>
                
                    <!-- Item -->
                    <div class="mb-4 bgform">
                        <span class="rounded-circle number"><b>2</b></span>
                        <span style="font-size: 25px; font-weight: bold;">Pilih Item</span>
                        <div class="row row-cols-sm-2 row-cols-md-3 gy-3">
                            @foreach ($items as $key=>$item)
                                <div class="col {{ ($item->stock === 0 ? 'disabled' : '') }}">
                                    <div class="form-check">
                                        <input class="btn-check" type="radio" id="{{ $key }}" name="item_id" value="{{ $item->id }}" data-price="{{ $item->price }}" {{ $item->stock === 0? 'disabled' : '' }}/>
                                        <label class="selected" for="{{ $key }}">
                                            <img src="{{ asset('storage/' . $item->icon) }}" alt="" class="mx-auto my-2" style="max-height: 50px;"><br>
                                            <b>{{ $item->item }}</b>
                                            @if ($item->discount !== null)
                                                @php
                                                    $i = $item->price;
                                                    $discount = $item->price * (1 - ($item->discount/100));
                                                @endphp
                                                <p>{{ 'Rp.' . number_format($discount, 2, ",", ".") }} </p>
                                                <hr>
                                                <p>{{ '-'. $item->discount .'% off' }} <span class="text-decoration-line-through opacity-50">{{ 'Rp.' . number_format($item->price, 2, ",", ".") }}</span></p>
                                            @else
                                                <p>{{ 'Rp.' . number_format($item->price, 2, ",", ".") }}</p>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                
                    <!-- Payment -->
                    <div class="mb-4 bgform">
                        <span class="rounded-circle number"><b>3</b></span>
                        <span style="font-size: 25px; font-weight: bold;">Pilih Metode Pembayaran</span>
                        <div class="row row-cols-1">
                            @foreach ($payments as $key => $payment)
                                <div class="col payment-option {{ ($payment->status === 'Unavailable' ? 'disabled' : '') }}">
                                    <div class="">
                                        <input type="radio" id="pay{{ $key }}" name="payment_id" value="{{ $payment->id }}" data-payment-id="{{ $payment->id }}" {{ ($payment->status === 'Unavailable' ? 'disabled' : '') }}>
                                        <label class="payment" for="pay{{ $key }}">
                                            <img src="{{ asset('storage/' . $payment->logo) }}" alt="" class="mx-5 p-2">
                                            <b class="text-end px-4">{{ $payment->method }}</b>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                
                    <!-- Whatsapp -->
                    <div class="mb-4 bgform">
                        <span class="rounded-circle number"><b>4</b></span>
                        <span style="font-size: 25px; font-weight: bold;">Konfirmasi No Whatsapp</span>
                        <div class="mb-3 form-floating">
                            <input type="number" id="floatingInputWa" name="Wa_Number" class="form-control" placeholder="Masukkan No. Wa"/>
                            <label for="floatingInputWa" class="text-black">Masukkan No. Wa</label>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="confirmButton" onclick="showConfirmation()" class="tombol">
                                <i class="fa-solid fa-plus"></i> Konfirmasi
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="game_id" value="{{ $games->id }}" />
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('input[disabled]').closest('.payment-option').css('opacity', '0.5');
        });
        
        // modal js
        function showConfirmation() {
            // Ambil nilai input dari form
            const idGame = document.querySelector('input[name="id_game"]').value;
            const selectedItem = document.querySelector('input[name="item_id"]:checked').nextElementSibling.querySelector('b').innerText; // Ambil <b> nama item
            const itemPrice = document.querySelector('input[name="item_id"]:checked').getAttribute('data-price');
            const paymentMethod = document.querySelector('input[name="payment_id"]:checked').nextElementSibling.querySelector('b').innerText; // Ambil <b> metode pembayaran
            const waNumber = document.querySelector('input[name="Wa_Number"]').value;

            // Tampilkan SweetAlert dengan data yang diambil
            Swal.fire({
                title: "Konfirmasi Transaksi",
                html: `
                <table class="table text-start">
                    <tr>
                        <td>ID Game</td>
                        <td>${idGame}</td>
                    </tr>
                    <tr>
                        <td>Item/ Unit</td>
                        <td>${selectedItem}</td>
                    </tr>
                    <tr>
                        <td>Harga Unit</td>
                        <td>Rp. ${Number(itemPrice).toLocaleString('id-ID')}</td>
                    </tr>
                    <tr>
                        <td>Metode Pembayaran</td>
                        <td>${paymentMethod}</td>
                    </tr>
                    <tr>
                        <td>Nomor Whatsapp</td>
                        <td>${waNumber}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Pastikan data yang anda masukkan sudah benar. Kesalahan input bukan merupakan tanggung jawab kami</td>
                    </tr>
                </table>`,
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Lanjutkan",
                denyButtonText: `Batalkan`,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, submit form
                    document.getElementById('transaksiForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Transaksi dibatalkan", "", "info");
                }
            });
        }
    </script>
    @include('partials.footer')
@endsection