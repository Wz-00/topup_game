@extends('layouts.main')

@section('body')
<style>
    .col, .kiri .head {
        font-family: fantasy; 
    }
    .head {
        font-size:40px;
    }
    .kiri .head {
        font-size: 30px;
    }
    .kiri{
        background-color: #1f2122;
    }
    .kanan{
        background-color: #424242;
    }
    .row button {
        background-color: #e75e8d;
        border: none;
        border-radius: 15px;
        padding: 5px 15px;
        color: white;
    }
    .col li a {
        color: white;
        text-decoration: none;
    }
    .col li a:hover {
        color: #e75e8d;
    }
    .col li a::after {
        color: #e75e8d;
    }
</style>
    <div class="container-fluid my-4">
        <div class="p-4 text-light">
            <div class="grid mx-5" style="--bs-columns: 3;">
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
                <div class="g-col-3 g-col-xl-1">
                    <div class="row row-cols-1">
                        <div class="col head">Account Management</div>
                        <div class="col" style="font-size:21px">
                            <ul>
                                <li><a href="#CompanySettings"><i class="fa-solid fa-building"></i>&emsp;Company Settings</a></li>
                                <li><a href="#SocialMedia"><i class="fa-solid fa-mobile-screen-button"></i>&emsp;Social Media</a></li>
                                <li><a href="#PasswordManagement"><i class="fa-solid fa-key"></i>&emsp;Password Management</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="g-col-3 g-col-xl-2">
                    <div class="row mb-3" id="CompanySettings">
                        <div class="col-xl-4 col-lg-12 p-4 kiri">
                            <p class="head">Company Settings</p>
                            <p>Edit tampilan perusahaanmu di sini</p>
                        </div>
                        <div class="col-xl-8 col-lg-12 p-4 kanan">
                            <form action="{{ route('update.company') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row row-cols-1">
                                    <div class="col mb-3 d-flex justify-content-center">
                                        <img src="{{ asset('storage/' . $company->logo) }}" alt="" id="preview_logo_image">
                                        <input type="file" id="preview_logo" name="preview_logo" accept="image/*" style="display:none;" onchange="previewImage('preview_logo', 'preview_logo_image')">
                                    </div>
                                    <div class="col mb-3 d-flex justify-content-center">
                                        <button class="button" type="button" id="preview_logo_button">Change Image</button>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="form-floating">
                                            <input type="text" id="floatingInput" class="form-control" placeholder="Your Company Name" name="name" value="{{ $company->name }}"/>
                                            <label for="floatingInput" class="text-black">Your Company Name</label>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="form-floating">
                                            <textarea id="deskripsi" name="description" class="form-control" style="height: 315px;" placeholder="Your Company Description">{{ $company->description }}</textarea>
                                            <label for="deskripsi" class="text-black">Your Company Description</label>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <button class="button" type="submit">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mb-3" id="SocialMedia">
                        <div class="col-xl-4 col-lg-12 p-4 kiri">
                            <p class="head">Social Media</p>
                            <p>Jika anda memasukkan link social media anda, user akan mudah untuk menghubungi anda</p>
                        </div>
                        <div class="col-xl-8 col-lg-12 p-4 kanan">
                            <form action="{{ route('update.company') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-12 mb-3">
                                        <span class="iconify" data-icon="skill-icons:instagram" data-inline="false" style="font-size: 150px;"></span>
                                    </div>
                                    <div class="col-lg-8 col-md-12 d-flex align-items-center mb-3">
                                        <div class="form-floating" style="width: 100%">
                                            <input type="text" id="floatingInput" class="form-control" placeholder="Your Instagram link" value="{{ $company->ig }}" name="ig"/>
                                            <label for="floatingInput" class="text-black">Your Instagram link</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 mb-3">
                                        <span class="iconify" data-icon="devicon:facebook" data-inline="false" style="font-size: 150px;"></span>
                                    </div>
                                    <div class="col-lg-8 col-md-12 d-flex align-items-center mb-3">
                                        <div class="form-floating" style="width: 100%">
                                            <input type="text" id="floatingInput" class="form-control" placeholder="Your Facebook link" value="{{ $company->fb }}" name="fb"/>
                                            <label for="floatingInput" class="text-black">Your Facebook link</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 mb-3">
                                        <span class="iconify" data-icon="logos:tiktok-icon" data-inline="false" style="font-size: 150px;"></span>
                                    </div>
                                    <div class="col-lg-8 col-md-12 d-flex align-items-center mb-3">
                                        <div class="form-floating" style="width: 100%">
                                            <input type="text" id="floatingInput" class="form-control" placeholder="Your Tiktok link" value="{{ $company->tiktok }}" name="tiktok"/>
                                            <label for="floatingInput" class="text-black">Your Tiktok link</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 mb-3">
                                        <span class="iconify" data-icon="logos:whatsapp-icon" data-inline="false" style="font-size: 150px;"></span>
                                    </div>
                                    <div class="col-lg-8 col-md-12 d-flex align-items-center mb-3">
                                        <div class="form-floating" style="width: 100%">
                                            <input type="text" id="floatingInput" class="form-control" placeholder="Your WhatsApp link" value="{{ $company->wa }}" name="wa"/>
                                            <label for="floatingInput" class="text-black">Your WhatsApp link</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 mb-3">
                                        <span class="iconify" data-icon="logos:google-gmail" data-inline="false" style="font-size: 110px;"></span>
                                    </div>
                                    <div class="col-lg-8 col-md-12 d-flex align-items-center mb-3">
                                        <div class="form-floating" style="width: 100%">
                                            <input type="text" id="floatingInput" class="form-control" placeholder="Your Email" value="{{ $company->email }}" name="email"/>
                                            <label for="floatingInput" class="text-black">Your Email</label>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <button class="button" type="submit">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mb-3" id="PasswordManagement">
                        <div class="col-xl-4 col-lg-12 p-4 kiri">
                            <p class="head">Password Management</p>
                            <p>Kami merekomendasikan anda mengganti password setiap 3 bulan sekali untuk mencegah otorisasi tidak dikenal di akun anda</p>
                        </div>
                        <div class="col-xl-8 col-lg-12 p-4 kanan password">
                            <div class="row row-cols-1">
                                <form action="{{ route('update.password') }}" method="POST">
                                    @csrf
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @elseif (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <div class="col mb-3">
                                        <div class="form-floating">
                                            <input type="password" id="oldpassword" name="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Current Password"/>
                                            <label for="oldpassword" class="text-black">Current Password</label>
                                            @error('old_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="form-floating">
                                            <input type="password" id="newPassword" name="new_password" class="form-control" placeholder="New Password"/>
                                            <label for="newPassword" class="text-black">New Password</label>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="form-floating">
                                            <input type="password" id="newPasswordConfirmation" name="new_password_confirmation" class="form-control" placeholder="Confirm New Password"/>
                                            <label for="newPasswordConfirmation" class="text-black">Confirm New Password</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col d-flex justify-content-end">
                                        <button class="button">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const oldpassword = document.querySelector('#oldpassword');
    const newpassword = document.querySelector('#newPassword');
    const confirmpassword = document.querySelector('#newPasswordConfirmation');
    const password = [oldpassword, newpassword, confirmpassword]
    togglePassword.addEventListener('click', () => {
        // Toggle the type attribute using
        // getAttribure() method
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        
        password.setAttribute('type', type);
        
        
    });
    </script>
    <script src="/asset/js/item.js"></script>
    @include('partials.adminfooter')
@endsection