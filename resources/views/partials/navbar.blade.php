<style>
    .user{
        width: 100%;
        max-width: 300px;
    }
    .user img {
        aspect-ratio: 1/1;
        object-fit:cover;
    }
    li a .number {
        position: absolute;
        background-color: red;
        width: 20px;
        height: 20px;
        text-align: center;
        color: white;
    }
</style>
@php
    if (Auth::check()) {
        $name = auth()->user()->name;
        $user = Str::words($name , 1,'');
    }
    $companyname = $company->name;
    
    $companys = Str::limit($companyname, 13, '..')
@endphp
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <ul class="nav justify-content-start">
                @if (Auth::check())
                <button class="btn" id="button-toggle">
                    <i class="fa-solid fa-equals" style="color:white"></i>
                </button>
                @else
                    <script>
                        // Membuat elemen HTML tombol dalam bentuk `const html`
                        const html = `
                            <button class="btn" id="button-toggle" type="button">
                                <i class="fa-solid fa-equals" style="color:white"></i>
                            </button>
                        `;
                            
                        // Fungsi untuk menambahkan tombol jika ukuran layar <= 666px
                        function checkWidthAndAddButton() {
                            if (window.innerWidth <= 666) {
                                // Menambahkan tombol ke dalam ul.nav jika belum ada
                                if (!document.getElementById('button-toggle')) {
                                    document.querySelector('.nav').insertAdjacentHTML('afterbegin', html);
                                }
                            } else {
                                // Menghapus tombol jika ukuran layar > 666px
                                const existingButton = document.getElementById('button-toggle');
                                if (existingButton) existingButton.remove();
                            }
                        }
                
                        // Panggil fungsi saat halaman pertama kali dimuat
                        checkWidthAndAddButton();
                
                        // Event listener untuk memantau perubahan ukuran layar
                        window.addEventListener('resize', checkWidthAndAddButton);
                        
                    </script>
                
                @endif
                <a href='/' class='navbar-brand text-light'>
                    <img src="{{ asset('storage/' . $company->logo) }}" class="navbar-logo" alt="logo">
                    <span id="companyName"></span>
                    <script>
                        function displayCompanyName() {
                            const companyNameContainer = document.getElementById("companyName");

                            // Cek lebar layar
                            if (window.innerWidth <= 376) {
                                companyNameContainer.innerHTML = "<b>{{ $companys }}</b>";
                            } else {
                                companyNameContainer.innerHTML = "<b>{{ $company->name }}</b>";
                            }
                        }

                        // Panggil fungsi saat halaman dimuat
                        displayCompanyName();

                        // Panggil fungsi saat ukuran layar diubah
                        window.addEventListener("resize", displayCompanyName);
                    </script>
                </a>
            </ul>
            <ul class="nav justify-content-end align-content-center" style="height: 100%; max-height:61.42px">
                @if(Auth::check())
                    @if(Auth::user()->role === 'admin')
                        <li class="profile-dropdown my-auto">
                            <div onclick="toggle()" class="profile-dropdown-btn text-light">
                                <span class="user">
                                    @php
                                        $avatar = auth()->user()->avatar;
                                    @endphp 
                                    <div class="d-flex justify-content-between">
                                        <img src="{{ auth()->user()->avatar === null ? '/asset/img/person-icon.png' : asset('storage/' . $avatar) }}" alt="" height="43" class="rounded-circle">
                                        <p class="my-auto">{{ auth()->user()->name }}</p>
                                        
                                    </div>
                                </span>
                            </div>
        
                            <ul class="profile-dropdown-list">
                                <li class="profile-dropdown-list-item">
                                    <a href="/profile">
                                        <i class="fa-regular fa-user"></i>
                                        Profile
                                    </a>
                                </li>
        
                                <li class="profile-dropdown-list-item">
                                    <a href="/transaksi">
                                        @if($countTransaction > 0)
                                            <span class="number rounded-circle" style="top: 90px;">
                                                {{ $countTransaction }}
                                            </span>
                                        @endif
                                        <i class="fa-solid fa-file-invoice"></i>
                                        Transaksi
                                    </a>
                                </li>
                                <hr />
                                <li class="profile-dropdown-list-item">
                                    <a href="/logout">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                        Log out
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item" id="navlist">
                            <a href="/cari-pesanan" class="nav-link {{ ($title === 'Cari Pesanan' ? 'recolor' : '') }}" id="link1">Cek Pesanan</a>
                            <a href="/contact" class="nav-link {{ ($title === 'Contact' ? 'recolor' : '') }}" id="link1">Kontak Admin</a>
                        </li>
                        <li class="profile-dropdown my-auto">
                            <div onclick="toggle()" class="profile-dropdown-btn text-light">
                                <span class="user">
                                    @php
                                        $avatar = auth()->user()->avatar;
                                    @endphp 
                                    <div class="d-flex justify-content-between">
                                        <img src="{{ auth()->user()->avatar === null ? '/asset/img/person-icon.png' : asset('storage/' . $avatar) }}" alt="" height="40" class="rounded-circle">
                                        <p class="my-auto">{{ $user }}</p>
                                    </div>
                                </span>
                            </div>
        
                            <ul class="profile-dropdown-list ">
                                <li class="profile-dropdown-list-item ">
                                    <a href="/profile">
                                        <i class="fa-regular fa-user"></i>
                                        Profile
                                    </a>
                                </li>
        
                                <li class="profile-dropdown-list-item">
                                    <a href="/transaksi">
                                        @if($countTransaction > 0)
                                            <span class="number rounded-circle" style="top: 90px">
                                                {{ $countTransaction }}
                                            </span>
                                        @endif
                                        <i class="fa-solid fa-file-invoice"></i>
                                        Transaksi
                                        
                                    </a>
                                </li>
        
                                <li class="profile-dropdown-list-item">
                                    <a href="/contact">
                                        <i class="fa-regular fa-circle-question"></i>
                                        Help & Support
                                    </a>
                                </li>
                                
                                <hr />
        
                                <li class="profile-dropdown-list-item">
                                    <a href="/logout">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                        Log out
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @else
                    <li class="nav-item" id="navlist">
                        <a href="/cari-pesanan" class="nav-link {{ ($title === 'Cari Pesanan' ? 'recolor' : '') }}" id="link1">Cek Pesanan</a>
                        <a href="/contact" class="nav-link {{ ($title === 'Contact' ? 'recolor' : '') }}" id="link1">Kontak Admin</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="/contact" class="nav-link {{ ($title === 'Contact' ? 'recolor' : '') }}" id="link1">Kontak Admin</a>
                    </li> --}}
                    <li class='nav-item'><a href="/login" class="guest">Login</a></li>
                @endif
            </ul>
        </div>
    </nav>
    <script>
        function checkWidth() {
            const navbarList = document.getElementById('navlist');
            if (window.innerWidth <= 666) {
                navbarList.style.display = 'none';
            } else {
                navbarList.style.display = 'flex';
            }
        }

        // Panggil fungsi saat halaman dimuat dan saat ukuran layar berubah
        window.addEventListener('load', checkWidth);
        window.addEventListener('resize', checkWidth);
    </script>
