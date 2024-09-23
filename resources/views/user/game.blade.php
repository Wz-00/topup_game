@extends('layouts.main')

@section('navbar')
    @include('partials.navbar')
@endsection

@section('body')
    <div class="container containbg my-4 p-4">
        <div class="grid" style="--bs-columns: 3;">
            <div class="g-col-3 g-col-lg-1">
                <div class="content p-3">
                    <img src="{{ asset('storage/' . $games->image) }}" alt="" class="img-fluid">
                    <div class="p-2">
                        <h4 class="text-white">{{ $games->game }}</h4>
                        <p class="text-white">{{ $games->description }}</p>
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
                                <div class="col">
                                    <div class="form-check">
                                        <input class="btn-check" type="radio" id="{{ $key }}" name="item_id" value="{{ $item->id }}" data-price="{{ $item->price }}"/>
                                        <label class="selected" for="{{ $key }}">
                                            <img src="{{ asset('storage/' . $item->icon) }}" alt="" class="mx-auto my-2" style="max-height: 50px;"><br>
                                            <b>{{ $item->item }}</b>
                                            <p>{{ 'Rp.' . number_format($item->price, 2, ",", ".") }}</p>
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
                            @foreach ($payments as $key=>$payment)
                                <div class="col">
                                    <div class="">
                                        <input type="radio" id="pay{{ $key }}" name="payment_id" value="{{ $payment->id }}" data-payment-id="{{ $payment->id }}">
                                        <label class="payment" for="pay{{ $key }}">
                                            <img src="{{ asset('storage/' . $payment->logo) }}" alt="" class="mx-5 p-2">
                                            <b>{{ $payment->method }}</b>
                                            <b class="payment-price"></b>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- whatsapp -->
                    <div class="mb-4 bgform">
                        <span class="rounded-circle number"><b>4</b></span>
                        <span style="font-size: 25px; font-weight: bold;">Konfirmasi No Whatsapp</span>
                        <div class="mb-3 form-floating">
                            <input type="number" id="floatingInputWa" name="Wa_Number" class="form-control" placeholder="Masukkan No. Wa"/>
                            <label for="floatingInputWa" class="text-black">Masukkan No. Wa</label>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" id="confirmButton" class="tombol">
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
    @include('partials.footer')
@endsection