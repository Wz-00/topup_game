<link rel="stylesheet" href="/asset/css/footer.css">
<style>
    .menu-list{
        list-style: none;
        padding-left: 0;
    }
    .menu-list a{
        text-decoration: none;
        color: white;
    }
    .menu-list a:hover{
        color: #e75e8d;
    }
</style>
<div class="container">
    <div class="footer my-3">
        <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo Company" style="width: 50px;">
        <div class="row">
            <div class="col-lg-6 col-md-6 py-3">
                <h3>{{ $company->name }}</h3>
                <b>{{ $company->description }}</b>
                <div class="col-12 my-3">
                    <a href="https://www.instagram.com/{{ $company->ig }}"><span class="iconify" data-icon="skill-icons:instagram" data-inline="false" style="font-size: 50px;"></span></a>
                    <a href="https://www.facebook.com/{{ $company->fb }}"><span class="iconify" data-icon="devicon:facebook" data-inline="false" style="font-size: 50px;"></span></a>
                    <a href="https://www.tiktok.com/{{ $company->tiktok }}"><span class="iconify" data-icon="logos:tiktok-icon" data-inline="false" style="font-size: 50px;"></span></a>
                    <a href="https://api.whatsapp.com/send/?phone={{ $company->wa }}&text&type=phone_number&app_absent=0"><span class="iconify" data-icon="logos:whatsapp-icon" data-inline="false" style="font-size: 50px;"></span></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 text-white">
                <h3>Halaman</h3>
                <ul class="menu-list">
                    <li><a href="/">Halaman Utama</a></li>
                    <li><a href="/cari-pesanan">Cek Pesanan</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-3">
                <h3>Kontak</h3>
                <ul class="menu-list">
                    <li><a href="https://api.whatsapp.com/send/?phone={{ $company->wa }}&text&type=phone_number&app_absent=0"><span class="iconify" data-icon="mdi:whatsapp" data-inline="false" style="font-size: 30px;"></span>{{ $company->wa }}</a></li>
                    <li><a href="https://www.instagram.com/{{ $company->ig }}"><span class="iconify" data-icon="mdi:instagram" data-inline="false" style="font-size: 30px;"></span>&#64;{{ $company->ig }}</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-3">
                <h3>Member</h3>
                <ul class="menu-list">
                    <li><a href="/login">Sign In</a></li>
                    <li><a href="/register">Sign Up</a></li>
                </ul>
            </div>
        </div>
        {{-- <div class="grid my-4" style="--bs-columns: 3;">
            <div class="grid text-light" style="--bs-row: 3;">
                <img src="https://cas-asbestos.co.uk/wp-content/uploads/2014/06/dummy-logo.png" class="rounded-circle" height="50" alt="logo" loading="lazy" style="grid-row: 1" />
                <h4 class="g-col-4" style="grid-row: 2">Your Company</h4>
                <b class="g-col-4" style="grid-row: 3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero, dolorem!</b>
            </div>
            <div class="grid fkiri text-light" style="--bs-row: 2; --bs-column: 4;">
                <h4 class="g-col-4">Jangan lupa ikuti sosial media kami di</h4>
                <div class="g-start-1" style="grid-row: 2"><a href="https://www.instagram.com/hi_wizz"><img src="/asset/icon/Instagram_icon.png" alt="Instagram" /></a></div>
                <div class="g-start-2" style="grid-row: 2"><a href=""><img src="/asset/icon/Facebook_icon.png" alt="Facebook" /></a></div>
                <div class="g-start-3" style="grid-row: 2"><a href=""><img src="/asset/icon/tiktok_icon.png" alt="Tiktok" style="border-radius: 15px;" /></a></div>
            </div>
        </div> --}}
    </div>
</div>
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>