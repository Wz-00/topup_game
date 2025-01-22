@extends('layouts.main')

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
        max-width: 480px;

    }
</style>
    <div class="container">
        <div class="containadmin py-4 my-4">
            <form action="{{ route('payment.edit', $payments->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="grid" style="--bs-columns: 2;">
                    <div class="g-col-2 g-col-md-2 g-col-lg-1 mx-2">
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('storage/'. $payments->logo ) }}" alt="" id="preview_payment" class="mx-auto">
                        </div>
                        
                        <input type="file" id="preview_logo" name="preview_logo" accept="image/*" style="display:none;" onchange="previewImage('preview_logo', 'preview_payment')">
                        <div class="d-flex justify-content-center">
                            <button type="button" id="preview_logo_button" class="button text-center text-light">Select Logo</button>
                        </div>
                    </div>
                    <div class="g-col-2 g-col-md-2 g-col-lg-1">
                        <div class="bgform mb-4">
                            <div class="form-floating">
                                <input type="text" id="method" name="method" class="form-control @error('method') is-invalid @enderror" placeholder="Masukkan Nama Pembayaran" value="{{ $payments->method }}" >
                                <label for="method" class="text-black">Masukkan Nama Pembayaran</label>
                                @error('method')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="bgform mb-4">
                            <div class="form-floating">
                                <input type="number" id="number" name="number" class="form-control @error('number') is-invalid @enderror" placeholder="Masukkan Nomor Pembayaran" value="{{ $payments->number }}" >
                                <label for="number" class="text-black">Masukkan Nomor Pembayaran</label>
                                @error('number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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