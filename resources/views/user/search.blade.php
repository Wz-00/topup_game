@extends('layouts.main')

@section('body')
<link rel="stylesheet" href="/asset/css/modal.css">
<style>
    .button{
        background-color: #e75e8d;
        border: none;
        border-radius: 15px;
        padding: 5px 15px;
        color: white;
    }
    .img-area{
     height: 500px;  
    }
</style>
    <div class="pt-5"></div>
    <div class="pt-5 pb-5 mx-3">
        <div class="contentsc align-self-center mx-auto">
            <div class="d-flex flex-columns">
                <div class="container">
                    <form action="">
                        <p class="text-center text-light my-3" style="font-size:16px; font-weight:bold;">Cek Status Pesanan</p>
                        <div class="mb-3 form-floating">
                            <input type="number" id="floatingInput" name="search" class="form-control" placeholder="Masukkan ID Pesanan anda">
                            <label for="floatingInput" class="text-black">Masukkan ID Pesanan anda</label>
                        </div>
                        <div class="d-flex justify-content-end cek">
                            <button type="submit">Cek Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(isset($transaksi) && $transaksi)
        <div class="pb-5 mx-3">
            <div class="contentsc align-self-center mx-auto">
                <div class="d-flex flex-columns">
                    <div class="container">
                        <p class="text-center text-light my-3" style="font-size:16px; font-weight:bold;">Detail Pemesanan</p>
                        <div class="row text-light">
                            <div class="col">
                                <b>ID Game</b>
                                <p>{{ $transaksi->id_game }}</p>
                                <b>Metode Pembayaran</b>
                                <p>{{ $transaksi->payment->method }}</p>
                                <b>No. Rekening/ No. Virtual Account</b>
                                <p>{{ $transaksi->payment->number }}</p>
                                <b>Jumlah Pembayaran</b>
                                <p>{{ 'Rp.' . number_format($transaksi->price, 2, ",", ".") }}</p>
                            </div>
                            <div class="col">
                                <b>No. Transaksi</b>
                                <p>{{ $transaksi->id_transaksi }}</p>
                                <b>Waktu Transaksi</b>
                                <p>{{ $transaksi->created_at }}</p>
                                <b>Rincian Pemesanan</b>
                                <p>{{ $transaksi->game->game }}</p>
                                <b>Keterangan/ No. Token/ No. Voucher</b>
                                <p>{{ $transaksi->status === 'Konfirmasi Pembayaran' ? 'Proses' : $transaksi->status }}</p>
                            </div>
                        </div>
                        @if ($transaksi->status === 'Menunggu Pembayaran')
                            <p><b>Selesaikan Transaksi Sebelum : </b><span id="countdown-{{ $transaksi->id }}"></span></p>
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
                            <form action="{{ route('bukti', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @elseif(request()->has('search'))
        <div class='pb-5 mx-3'>
            <div class='contentsc align-self-center mx-auto'>
                <div class='d-flex flex-columns'>
                    <div class='container'>
                        <p class='text-center text-light my-3' style='font-size:16px; font-weight:bold;'>Detail Pemesanan</p>
                        <p class='text-center text-light my-3'>ID Tidak Ditemukan</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('footer')
    @include('partials.footer')
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


                const uploadContainer = document.getElementById('upload-container');
        const fileInput = document.getElementById('file-input');
        const browseButton = document.getElementById('browse-button');
        const uploadButton = document.getElementById('upload-button');

        // Fungsi untuk menampilkan preview gambar
        function showImagePreview(file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                // Ubah tampilan div upload menjadi preview gambar
                uploadContainer.innerHTML = `
                    <img src="${event.target.result}" alt="Preview Image" style="max-width: 100%; height: auto; border-radius: 8px;">
                    <p>${file.name}</p>
                    <button id="change-image-button" class="button" style="margin-top: 10px;" type="button">Change Image</button>
                `;
                // uploadButton.style.display = "block"; // Tampilkan tombol upload

                // Tambahkan event listener ke tombol "Change Image"
                const changeImageButton = document.getElementById('change-image-button');
                changeImageButton.addEventListener('click', () => {
                    fileInput.click(); // Trigger klik pada input file
                });
            };
            reader.readAsDataURL(file);
        }

        // Event untuk menangani tombol "Browse File"
        browseButton.addEventListener('click', () => {
            fileInput.click(); // Trigger klik pada input file
        });

        // Event untuk menangani input file
        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                showImagePreview(file); // Tampilkan preview jika file dipilih
            }
        });

        // Event untuk menangani drag & drop
        uploadContainer.addEventListener('dragover', (event) => {
            event.preventDefault(); // Cegah default browser
            uploadContainer.style.border = "2px dashed #fff"; // Tambah efek drag
        });

        uploadContainer.addEventListener('dragleave', () => {
            uploadContainer.style.border = "none"; // Hapus efek drag
        });

        uploadContainer.addEventListener('drop', (event) => {
            event.preventDefault(); // Cegah default browser
            uploadContainer.style.border = "none"; // Hapus efek drag
            const file = event.dataTransfer.files[0];
            if (file) {
                showImagePreview(file); // Tampilkan preview jika file di-drop
            }
        });
    </script>
@endsection