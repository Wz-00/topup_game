@extends('layouts.main')

@section('body')
<link rel="stylesheet" href="/asset/css/modal.css">
{{-- <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    :root {
        --blue: #0071FF;
        --light-blue: #B6DBF6;
        --dark-blue: #005DD1;
        --grey: #f2f2f2;
    }

    
    .img-area {
        position: relative;
        width: 100%;
        height: 240px;
        background: var(--grey);
        margin-bottom: 30px;
        border-radius: 15px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .img-area .icon {
        font-size: 100px;
    }
    .img-area h3 {
        font-size: 20px;
        font-weight: 500;
        margin-bottom: 6px;
    }
    .img-area p {
        color: #999;
    }
    .img-area p span {
        font-weight: 600;
    }
    .img-area img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        z-index: 100;
    }
    .img-area::before {
        content: attr(data-img);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .5);
        color: #fff;
        font-weight: 500;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        pointer-events: none;
        opacity: 0;
        transition: all .3s ease;
        z-index: 200;
    }
    .img-area.active:hover::before {
        opacity: 1;
    }
    .select-image {
        display: block;
        width: 100%;
        padding: 16px 0;
        border-radius: 15px;
        background: var(--blue);
        color: #fff;
        font-weight: 500;
        font-size: 16px;
        border: none;
        cursor: pointer;
        transition: all .3s ease;
    }
    .select-image:hover {
        background: var(--dark-blue);
    }
</style> --}}
@if (session('success'))
    <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            position: "top-end",
            icon: "error",
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif
    <div class="container py-5 containbg my-3">
        <h3 class="text-center"><b>Detail Pembayaran</b></h3>
        <div class="nota greetings">
            <b>Terima Kasih</b>
            <p>Pesanan anda berhasil dibuat. Masa berlaku untuk No. Transaksi ini 24 jam, segera lakukan pembayaran agar pesanan segera diproses.</p>
            <p>Simpan No. Transaksi anda untuk Cek Status Pesanan!</p>
            <p>ScreenShot atau Foto bukti pembayaranmu untuk melanjutkan transaksi!</p>
        </div>
        <div class="nota detail my-3">
            <div class="row">
                <div class="col">
                    <b>ID Game</b>
                    <p>{{ $transaksi->id_game }}</p>
                    <b>Metode Pembayaran</b>
                    <p>{{ $transaksi->payment->method }}</p>
                    <b>No. Rekening/ No. Virtual Account</b>
                    <p>{{ $transaksi->payment->number }}</p>
                    <b>Jumlah Pembayaran</b>
                    <p>{{ 'Rp.' . number_format($transaksi->price, 2, ",", ".") }}</p>
                    @if ($transaksi->status === 'Menunggu Pembayaran')
                        <b>Selesaikan Transaksi Sebelum</b>
                        <p>
                            <span id="countdown-{{ $transaksi->id }}"></span>
                        </p>
                    @endif
                </div>
                <div class="col">
                    <b>No. transaksi</b>
                    <p>{{ $transaksi->id_transaksi}}</p>
                    <b>Waktu transaksi</b>
                    <p>{{ $transaksi->created_at }}</p>
                    <b>Rincian Pemesanan</b>
                    <p>{{ $transaksi->game->game }}</p>
                    <b>Keterangan/ No. Token/ No. Voucher</b>
                    <p>{{ $transaksi->status === "Konfirmasi Pembayaran" ? "Proses" : $transaksi->status}}</p>
                    
                </div>
            </div>
            
        </div>
        @if ($transaksi->status === "Bukti Tidak Sesuai")
            <div class="nota">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('storage/' . $transaksi->bukti) }}" alt="" class="img-fluid" style="max-height: 500px; height:100%">
                </div>
                
            </div>
        @endif
        @if ($transaksi->status === 'Menunggu Pembayaran')   
            <div class="nota">
                <h3>Upload Bukti Pembayaranmu!</h3>
                <form action="{{ route('bukti.upload', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center">
                        <input name="bukti" type="file" id="file" accept="image/*" hidden>
                        <div class="img-area" data-img="">
                            <i class='bx bxs-cloud-upload icon'></i>
                            <h3>Upload Image</h3>
                            <p>Image size must be less than <span>2MB</span></p>
                        </div>
                        <button class="select-image button" type="button">Select Image</button>
                    </div>
                    <input type="hidden" name="status" value="Konfirmasi Pembayaran">
                    <button id="upload-button" class="button" type="submit" style="">Upload</button>
                </form>
                
            </div>
        {{-- <form action="{{ route('bukti.upload', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="bukti">
            <input type="hidden" name="status" value="Konfirmasi Pembayaran">
            <button type="submit">submit</button>
        </form> --}}
        @endif
        
    </div>
@endsection
@section('footer')
    <script>
        // Fungsi upload gambar
        const selectImage = document.querySelector('.select-image');
        const inputFile = document.querySelector('#file');
        const imgArea = document.querySelector('.img-area');

        selectImage.addEventListener('click', function () {
            inputFile.click();
        })

        inputFile.addEventListener('change', function () {
            const image = this.files[0]
            if(image.size < 2000000) {
                const reader = new FileReader();
                reader.onload = ()=> {
                    const allImg = imgArea.querySelectorAll('img');
                    allImg.forEach(item=> item.remove());
                    const imgUrl = reader.result;
                    const img = document.createElement('img');
                    img.src = imgUrl;
                    imgArea.appendChild(img);
                    imgArea.classList.add('active');
                    imgArea.dataset.img = image.name;
                }
                reader.readAsDataURL(image);
            } else {
                alert("Image size more than 2MB");
            }
        })

        // fungsi menampilkan waktu
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