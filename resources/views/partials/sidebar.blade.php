
<link rel="stylesheet" href="/asset/css/sidebar.css">
<div class="sidebar p-4" id="sidebar">
    @php
        $user = Auth::user();
    @endphp
    @if (Auth::check())
        @if ($user->role === 'admin')
            <style>
                .sidebar{
                    background-color: #1f2122;
                }
            </style>
            <h4 class="text-white">Your Company</h4>
            <li>
                <!-- dashboard, produk, kategori, report, kasir -->
                <a href="/">
                    <i class="fa-solid fa-house-chimney"></i> 
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/transaksi">
                    <i class="fa-solid fa-cart-plus"></i> 
                    Transaction
                    @if($countTransaction > 0)
                        <span class="number rounded-circle" style="top: 100px">
                            {{ $countTransaction }}
                        </span>
                    @endif
                </a>
            </li>
            <li>
                <a href="/revenue">
                    <i class="fa-solid fa-chart-simple"></i> 
                    Revenue
                </a>
            </li>
            <li>
                <a href="/payment">
                    <i class="fa-regular fa-credit-card"></i>
                    Payment Method
                </a>
            </li>
            <li>
                <a href="/banner">
                    <i class="fa-solid fa-chart-line"></i>
                    Promote Your Game
                </a>
            </li>
            <li>
                <a href="/contact">
                    <i class="fa-solid fa-message"></i>
                    Messages
                    @if($countMessage > 0)
                        <span class="number rounded-circle" style="top:275px">
                            {{ $countMessage }}
                        </span>
                    @endif
                </a>
            </li>
            <hr style="color: white">
            <li>
                <a href="/profile">
                    <i class="fa-solid fa-user-large"></i> 
                    Accounts
                </a>
            </li>
        @else
            <style>
                .sidebar{
                    background-color: #27292a;
                }
            </style>
                <h4 class="text-white">Welcome, {{ $user->name }}</h4>
                <ul>
                    <li>
                        <a href="/">
                            <i class="fa-solid fa-house-chimney"></i> 
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="/transaksi">
                            <i class="fa-solid fa-cart-plus"></i> 
                            Transaksi
                            @if($countTransaction > 0)
                                <span class="number rounded-circle" style="top: 100px">
                                    {{ $countTransaction }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="/cari-pesanan">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            Cek Pesananan
                        </a>
                    </li>
                    <li>
                        <a href="/contact">
                            <i class="fa-solid fa-address-book"></i>
                            Kontak Admin
                        </a>
                    </li>
                    <hr style="color: white">
                    <li>
                        <a href="/profile">
                            <i class="fa-solid fa-user-large"></i> 
                            Akun
                        </a>
                    </li>
                </ul>
        @endif
    @else
        <style>
            .sidebar{
                background-color: #27292a;
            }
        </style>
        <ul>
            <li>
                <a href="/cari-pesanan">
                    <span class="iconify" data-icon="ic:twotone-search" data-inline="false"
                                style="font-size: 30px; color:white;"></span>
                    Cek Pesananan
                </a>
            </li>
            <li>
                <a href="/contact">
                    <span class="iconify" data-icon="fluent-mdl2:contact-info" data-inline="false"
                                style="font-size: 30px; color:white;"></span>
                    Kontak Admin
                </a>
            </li>
        </ul>
    @endif
</div>