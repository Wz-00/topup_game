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
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <ul class="nav justify-content-start">
                @if (Auth::check())
                <button class="btn" id="button-toggle">
                    <i class="fa-solid fa-equals" style="color:white"></i>
                </button>
                @endif
                <a href='/' class='navbar-brand text-light'>
                    <img src="{{ asset('storage/' . $company->logo) }}" class="navbar-logo" alt="logo" style="width: 50px">
                    <b>{{ $company->name }}</b>
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
                        <li class="nav-item">
                            <a href="/cari-pesanan" class="nav-link {{ ($title === 'Cari Pesanan' ? 'recolor' : '') }}" id="link1">Cek Pesanan</a>
                        </li>
                        <li class="nav-item">
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
                                        <p class="my-auto">{{ auth()->user()->name }}</p>
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
                    <li class="nav-item">
                        <a href="/cari-pesanan" class="nav-link {{ ($title === 'Cari Pesanan' ? 'recolor' : '') }}" id="link1">Cek Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a href="/contact" class="nav-link {{ ($title === 'Contact' ? 'recolor' : '') }}" id="link1">Kontak Admin</a>
                    </li>
                    <li class='nav-item'><a href="/login" class="guest">Login</a></li>
                @endif
            </ul>
        </div>
    </nav>
