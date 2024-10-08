@extends('layouts.main')

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
    @php
        if (Auth::check()) {
            $wa = Auth::user()->Wa;
        }
    @endphp
    <div class="container containbg my-4">
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
                            <input type="text" id="floatingInput" name="id_game" class="form-control @error('id_game') is-invalid @enderror" placeholder="Riot ID" required/>
                            <label for="floatingInput" class="text-black">ID Game</label>
                            @error('id_game')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
                                        @php
                                            $i = $item->price;
                                            $discount = $item->price * (1 - ($item->discount/100));
                                        @endphp
                                        <input required class="btn-check" type="radio" id="{{ $key }}" name="item_id" value="{{ $item->id }}" data-price="{{ $item->discount === null ? $item->price : $discount }}" {{ $item->stock === 0? 'disabled' : '' }}/>
                                        <label class="selected" for="{{ $key }}">
                                            <img src="{{ asset('storage/' . $item->icon) }}" alt="" class="mx-auto my-2" style="max-height: 50px;"><br>
                                            <b>{{ $item->item }}</b>
                                            @if ($item->discount !== null || $item->coins !== null)
                                                @if ($item->discount !== null)
                                                    
                                                    <p>{{ 'Rp.' . number_format($discount, 2, ",", ".") }} </p>
                                                    <hr>
                                                    <p class="text-end">{{ '-'. $item->discount .'% off' }} <span class="text-decoration-line-through opacity-50">{{ 'Rp.' . number_format($item->price, 2, ",", ".") }}</span></p>
                                                @endif
                                                
                                                @if ($item->coins !== null)
                                                    @if ($item->discount === null)
                                                        <p>{{ 'Rp.' . number_format($item->price, 2, ",", ".") }}</p>
                                                        <hr>
                                                    @endif
                                                    <p class="text-end"><span class="iconify" data-icon="streamline:dollar-coin-solid" data-inline="false"
                                                        style="color:#fbff00;"></span> {{ $item->coins }} Reward</p>
                                                @endif
                                            @else
                                                <p>{{ 'Rp.' . number_format($item->price, 2, ",", ".") }}</p>
                                            @endif
                                        </label>
                                        @error('item_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                @if (auth()->check()) 
                                    {{-- Jika user sudah login, tampilkan semua payment --}}
                                    <div class="col payment-option {{ ($payment->status === 'Unavailable' ? 'disabled' : '') }}">
                                        <div class="">
                                            <input required type="radio" id="pay{{ $key }}" name="payment_id" value="{{ $payment->id }}" data-payment-id="{{ $payment->id }}" {{ ($payment->status === 'Unavailable' ? 'disabled' : '') }}>
                                            <label class="payment" for="pay{{ $key }}">
                                                <b class="text-end px-4"><img src="{{ asset('storage/' . $payment->logo) }}" alt="" class="mx-5 p-2">
                                                {{ $payment->method }}</b>
                                                {{-- Jika payment id 1, tampilkan coin user --}}
                                                @if ($payment->id == 1)
                                                    <b class="text-end px-4">Coins: {{ auth()->user()->coins === null ? '0' : auth()->user()->coins }}</b>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            // Ambil coins pengguna dari server
                                            var userCoins = {{ auth()->user()->coins ?? 0 }};
                                    
                                            // Dapatkan semua radio button item
                                            var itemRadios = document.querySelectorAll('input[name="item_id"]');
                                            
                                            // Dapatkan elemen payment dengan id 1
                                            var paymentOption1 = document.querySelector('input[name="payment_id"][value="1"]');
                                            var paymentOption1Label = document.querySelector('label[for="pay0"]'); // Gantilah 'pay0' sesuai id radio button untuk payment id 1
                                    
                                            // Fungsi untuk mengecek apakah item yang dipilih memiliki harga lebih besar dari coins
                                            function checkItemPrice() {
                                                // Dapatkan item yang dipilih
                                                var selectedItem = document.querySelector('input[name="item_id"]:checked');
                                                
                                                if (selectedItem) {
                                                    // Ambil harga item dari atribut data-price
                                                    var itemPrice = parseFloat(selectedItem.getAttribute("data-price"));
                                    
                                                    // Cek apakah harga item lebih besar dari coins user
                                                    if (itemPrice > userCoins) {
                                                        // Disable payment method id 1, tambahkan class disabled, dan deselect (uncheck) payment id 1 jika sudah dipilih
                                                        paymentOption1.setAttribute("disabled", "disabled");
                                                        paymentOption1Label.classList.add("disabled");
                                    
                                                        // Jika payment id 1 terpilih, deselect (uncheck)
                                                        if (paymentOption1.checked) {
                                                            paymentOption1.checked = false;
                                                        }
                                                    } else {
                                                        // Enable payment method id 1 dan hapus class disabled
                                                        paymentOption1.removeAttribute("disabled");
                                                        paymentOption1Label.classList.remove("disabled");
                                                    }
                                                }
                                            }
                                    
                                            // Tambahkan event listener untuk setiap item
                                            itemRadios.forEach(function(radio) {
                                                radio.addEventListener("change", checkItemPrice);
                                            });
                                    
                                            // Jalankan fungsi saat pertama kali halaman dimuat untuk mengecek item yang dipilih
                                            checkItemPrice();
                                        });
                                    </script>
                                                                        
                                @else
                                    {{-- Jika user tidak login, hide payment dengan id 1 --}}
                                    @if ($payment->id != 1)
                                        <div class="col payment-option {{ ($payment->status === 'Unavailable' ? 'disabled' : '') }}">
                                            <div class="">
                                                <input type="radio" id="pay{{ $key }}" name="payment_id" value="{{ $payment->id }}" data-payment-id="{{ $payment->id }}" {{ ($payment->status === 'Unavailable' ? 'disabled' : '') }}>
                                                <label class="payment" for="pay{{ $key }}">
                                                    <img src="{{ asset('storage/' . $payment->logo) }}" alt="" class="mx-5 p-2">
                                                    <b class="text-end px-4">{{ $payment->method }}</b>
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                
                    <!-- Whatsapp -->
                    <div class="mb-4 bgform">
                        <span class="rounded-circle number"><b>4</b></span>
                        <span style="font-size: 25px; font-weight: bold;">Konfirmasi No Whatsapp</span>
                        <div class="mb-3 form-floating">
                            @if (Auth::check())
                                @php
                                    $wa = Auth::user()->Wa;
                                @endphp
                                <input type="number" id="floatingInputWa" name="Wa_Number" class="form-control" placeholder="Masukkan No. Wa" {{ $wa !== null ? 'disabled' : '' }} value="{{ $wa !== null ? $wa : '' }}"/>
                            @else
                            <input type="number" id="floatingInputWa" name="Wa_Number" class="form-control @error('Wa_Number') is-invalid @enderror" placeholder="Masukkan No. Wa" required/>
                            @endif
                            
                            <label for="floatingInputWa" class="text-black">Masukkan No. Wa</label>
                            @error('Wa_Number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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