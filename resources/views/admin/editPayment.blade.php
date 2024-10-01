@extends('layouts.main')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbaradmin')
@endsection

@section('body')
<style>
    form .button {
        display: inline-block;
        position: relative;
        background-color: #e75e8d;
        border: none;
        border-radius: 20px;
        padding: 5px 15px;
        color: white;
        font-size: 16px;
    }
    form img {
        width: 100%;
        max-width: 500px;
    }
</style>
    <div class="container">
        <div class="containadmin p-4">
            
            <form action="/payment/{{ $payments->slug }}/edit" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid" style="--bs-columns: 2;">
                    <div class="g-col-md-2 g-col-lg-1">
                        <img src="{{ asset('storage/'. $payments->logo ) }}" alt="" id="preview_payment">
                        <input type="file" id="preview_logo" name="preview_logo" accept="image/*" style="display:none;" onchange="previewImage('preview_logo', 'preview_payment')">
                        <div class="d-flex justify-content-center">
                            <button type="button" id="preview_logo_button" class="button text-center text-light">Select Logo</button>
                        </div>
                    </div>
                    <div class="g-col-md-2 g-col-lg-1">
                        <div class="bgform mb-4">
                            <div class="form-floating">
                                <input type="text" id="method" name="method" class="form-control" placeholder="Masukkan Nama Pembayaran" value="{{ $payments->method }}">
                                <label for="method" class="text-black">Masukkan Nama Pembayaran</label>
                            </div>
                        </div>
                        <div class="bgform mb-4">
                            <div class="form-floating">
                                <input type="number" id="number" name="number" class="form-control" placeholder="Masukkan Nomor Pembayaran" value="{{ $payments->number }}">
                                <label for="number" class="text-black">Masukkan Nomor Pembayaran</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="button" style="bottom: -37px"><i class="fa-solid fa-floppy-disk"></i>Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script src="/asset/js/item.js"></script>
    @include('partials.adminfooter')
@endsection