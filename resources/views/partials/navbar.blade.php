<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a href='/' class='navbar-brand text-light'>
            <img src="{{ asset('storage/' . $company->logo) }}" class="navbar-logo" alt="logo" style="width: 50px">
            <b>{{ $company->name }}</b>
        </a>
        <ul class="nav justify-content-end ">
            <li class="nav-item "><a href="/" class="nav-link {{ ($title === "Home" ? 'recolor' : '') }}" id="link1">Home</a></li>
            @if(Auth::check())
                @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a href="/revenue" class="nav-link {{ ($title === 'Revenue' ? 'recolor' : '') }}" id="link1">Revenue</a>
                    </li>
                    <li class="nav-item">
                        <a href="/transaksi" class="nav-link {{ ($title === 'Transaksi' ? 'recolor' : '') }}" id="link1">Transaksi</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="/cari-pesanan" class="nav-link {{ ($title === 'Cek Pesanan' ? 'recolor' : '') }}" id="link1">Cek Pesanan</a>
                    </li>
                @endif
            @else
                <li class="nav-item">
                    <a href="/cari-pesanan" class="nav-link {{ ($title === 'Cek Pesanan' ? 'recolor' : '') }}" id="link1">Cek Pesanan</a>
                </li>
            @endif
            @auth
            <div class="profile-dropdown">
                <div onclick="toggle()" class="profile-dropdown-btn text-light">
                    <span>
                        {{ auth()->user()->name }}
                        <i class="fa-solid fa-angle-down"></i>
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
                        <a href="#">
                            <i class="fa-regular fa-bell"></i>
                            Notification
                        </a>

                        <ul class="dropdown-menu dropdown-submenu dropdown-submenu-left">
                            <li>
                                <a class="dropdown-item" href="#">Submenu item 1</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Submenu item 2</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Submenu item 4</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Submenu item 5</a>
                            </li>
                        </ul>
                    </li>

                    <li class="profile-dropdown-list-item">
                        <a href="">
                            <i class="fa-regular fa-circle-question"></i>
                            Help & Support
                        </a>
                    </li>
                    <li class="profile-dropdown-list-item">
                        <a href="">
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
            </div>
            @else
                <li class='nav-item'><a href="/login" class="guest">Login</a></li>
            @endauth
            
        </ul>
    </div>
</nav>