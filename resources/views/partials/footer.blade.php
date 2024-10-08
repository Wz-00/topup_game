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
            <div class="col-lg-5 col-md-6 py-3">
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
                    <li><a href="/contact">Kontak Admin</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3">
                <h3>Kontak</h3>
                <ul class="menu-list">
                    <li><a href="https://api.whatsapp.com/send/?phone={{ $company->wa }}&text&type=phone_number&app_absent=0"><span class="iconify" data-icon="mdi:whatsapp" data-inline="false" style="font-size: 30px;"></span>+{{ $company->wa }}</a></li>
                    <li><a href="https://www.instagram.com/{{ $company->ig }}"><span class="iconify" data-icon="mdi:instagram" data-inline="false" style="font-size: 30px;"></span>&#64;{{ $company->ig }}</a></li>
                    <li><a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $company->email }}&su=Subject&body=Message"><span class="iconify" data-icon="ic:baseline-email" data-inline="false" style="font-size: 30px;"></span>&#64;{{ $company->email }}</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-3">
                <h3>Member</h3>
                <ul class="menu-list">
                    @if (Auth::check())
                        <li><a href="/logout">Logout</a></li>
                    @else
                        <li><a href="/login">Sign In</a></li>
                        <li><a href="/register">Sign Up</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    // event will be executed when the toggle-button is clicked
    document.getElementById("button-toggle").addEventListener("click", () => {

        // when the button-toggle is clicked, it will add/remove the active-sidebar class
        document.getElementById("sidebar").classList.toggle("active-sidebar");

        // when the button-toggle is clicked, it will add/remove the active-main-content class
        document.getElementById("main-content").classList.toggle("active-main-content");
    });


</script>
